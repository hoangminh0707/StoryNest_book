<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Hiển thị danh sách thanh toán
    public function index()
    {
        $payments = Payment::with(['order', 'details'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    // Hiển thị chi tiết thanh toán
    public function show($id)
    {
        $payment = Payment::with(['order', 'details'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
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

        return redirect()->route('admin.payments.index')->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Xóa thanh toán
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->details()->delete(); // Xoá chi tiết trước
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Xóa thanh toán thành công!');
    }
}
