<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => ['required', 'regex:/^[0-9]{10,12}$/'],
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ], [
        'name.required' => 'Họ và tên không được để trống.',
        'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

        'phone.required' => 'Số điện thoại không được để trống.',
        'phone.regex' => 'Số điện thoại phải là số và có từ 10 đến 12 chữ số.',

        'email.required' => 'Email không được để trống.',
        'email.email' => 'Email không đúng định dạng.',

        'subject.required' => 'Tiêu đề không được để trống.',
        'subject.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

        'message.required' => 'Nội dung không được để trống.',
        'message.min' => 'Nội dung phải có ít nhất 10 ký tự.',
    ]);


        // (Tuỳ chọn) Gửi email tới admin
        Mail::raw("Tên: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['phone']}\nSubject: {$data['subject']}\n\nNội dung:\n{$data['message']}", function ($msg) use ($data) {
            $msg->to('dtmgog@gmail.com')->subject('Liên hệ từ khách hàng');
        });

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.');
    }
}
