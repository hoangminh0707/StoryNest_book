<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Client\CheckoutClientController;

class VnpayController extends Controller
{
    public function createPaymentUrl(Request $request)
    {
        $pending = session('pending_checkout');

        if (!$pending) {
            return redirect()->route('checkout')->with('error', 'Thông tin đơn hàng không hợp lệ.');
        }

        $vnp_Url = config('vnpay.url');
        $vnp_Returnurl = route('vnpay.callback');
        $vnp_TmnCode = config('vnpay.tmn_code');
        $vnp_HashSecret = config('vnpay.hash_secret');

        $orderCode = 'ORDER' . time();

        $vnp_TxnRef = $orderCode;
        $vnp_OrderInfo = 'Thanh toan don hang ' . $orderCode;
        $vnp_Amount = 100000 * 100; // Số tiền test tạm: 100,000đ → nhân 100 theo yêu cầu VNPAY
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

            // ✅ Thêm dòng này để fix lỗi
            "vnp_BankCode" => "NCB"
        ];



        ksort($inputData);

        // Tạo chuỗi để hash (KHÔNG mã hóa)
        $hashDataArr = [];
        foreach ($inputData as $key => $value) {
            $hashDataArr[] = $key . '=' . $value;
        }
        $hashData = implode('&', $hashDataArr);

        $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);


        // Tạo query string (CÓ mã hóa)
        $queryArr = [];
        foreach ($inputData as $key => $value) {
            $queryArr[] = urlencode($key) . '=' . urlencode($value);
        }
        $queryString = implode('&', $queryArr);

        // Tạo URL cuối cùng
        $paymentUrl = $vnp_Url . '?' . $queryString . '&vnp_SecureHash=' . $vnp_SecureHash;

        \Log::info('HashData used: ' . $hashData);
        \Log::info('SecureHash: ' . $vnp_SecureHash);

        return redirect($paymentUrl);
    }



    public function handleCallback(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');

        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công → gọi tạo đơn hàng thật sự
            $checkoutController = new CheckoutClientController();
            return $checkoutController->createOrderFromSession();
        }

        return redirect()->route('checkout')->with('error', 'Thanh toán không thành công hoặc bị huỷ.');
    }
}