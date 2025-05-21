<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginAdminController extends Controller
{
    public function showLoginAdminForm()
    {
        return view('admin.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'errorsMsg' => 'Sai Thông Tin Đăng Nhập.',
        ])->withInput($request->only('errorsMsg'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }


}