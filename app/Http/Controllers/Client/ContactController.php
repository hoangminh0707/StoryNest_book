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
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // (Tuỳ chọn) Gửi email tới admin
        Mail::raw("Tên: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['phone']}\nSubject: {$data['subject']}\n\nNội dung:\n{$data['message']}", function ($msg) use ($data) {
            $msg->to('dtmgog@gmail.com')->subject('Liên hệ từ khách hàng');
        });

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.');
    }
}