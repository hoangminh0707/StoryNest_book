<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;


class VerificationClientController extends Controller
{
    public function notice()
    {
        return view('client.pages.auth.verify-email');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = Auth::user();


        if (!$user || $user->getKey() != $id) {
            abort(403);
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('index')->with('success', 'Email đã được xác minh.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('index')->with('success', 'Xác minh email thành công!');
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('index');
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        \Mail::send('client.pages.auth.verify', [
            'user' => $user,
            'verificationUrl' => $verificationUrl
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Xác minh địa chỉ email');
        });

        return back()->with('success', 'Email xác minh đã được gửi!');
    }

}