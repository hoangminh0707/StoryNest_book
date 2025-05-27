<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Client\CheckoutClientController;
use App\Http\Controllers\Controller;

class MomoController extends Controller
{
    public function createPayment()
    {
        $pending = session('pending_checkout');
        if (!$pending) {
            return redirect()->route('checkout')->with('error', 'Không tìm thấy thông tin đơn hàng.');
        }

        $endpoint = config('momo.endpoint');
        $partnerCode = config('momo.partner_code');
        $accessKey = config('momo.access_key');
        $secretKey = config('momo.secret_key');
        $orderId = time() . "";
        $orderInfo = "Thanh toán đơn hàng #" . $orderId;
        $amount = $pending['final_amount'] ?? 100000; // fallback

        $returnUrl = config('momo.return_url');
        $notifyUrl = config('momo.notify_url');
        $extraData = "";

        $requestId = time() . "";
        $requestType = "captureWallet";
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$notifyUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$returnUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        $jsonResult = json_decode($result, true);

        return redirect($jsonResult['payUrl'] ?? '/');
    }

    //link thanh toán test done http://localhost:8000/momo/return?resultCode=0
    public function handleReturn(Request $request)
    {
        // ⚠️ Tạm override resultCode để test
        $request->merge(['resultCode' => 0]);

        if ($request->resultCode == 0) {
            $checkout = new CheckoutClientController();
            return $checkout->createOrderFromSession();
        }

        return redirect()->route('checkout')->with('error', 'Thanh toán thất bại hoặc bị huỷ.');
    }

    public function handleCallback(Request $request)
    {
        Log::info("MOMO CALLBACK: " . json_encode($request->all()));
        return response()->json(['message' => 'OK'], 200);
    }
}