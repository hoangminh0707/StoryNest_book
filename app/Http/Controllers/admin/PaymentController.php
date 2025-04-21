<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Hiển thị danh sách thanh toán
    public function index()
    {
        $payments = Payment::with(['order', 'details', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Lấy đầy đủ danh sách phương thức thanh toán có phân trang
        $methods = PaymentMethod::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pages.payments.index', compact('payments', 'methods'));
    }

    // Hiển thị chi tiết thanh toán
    public function show($id)
    {
        $payment = Payment::with(['order', 'details', 'paymentMethod']) // thêm liên kết paymentMethod
            ->findOrFail($id);

        return view('admin.pages.payments.show', compact('payment'));
    }

    // Cập nhật trạng thái thanh toán (tuỳ chọn)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Xóa thanh toán
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        // Xoá chi tiết thanh toán nếu có
        if ($payment->details) {
            $payment->details()->delete();
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Xóa thanh toán thành công!');
    }
}