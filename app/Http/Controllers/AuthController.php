<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin() {
        return view('client.pages.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }
    
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }
    

    public function showRegister() {
        return view('client.pages.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'gender' => 'required|in:male,female,other',
            'birthdate' => 'required|date',
            'phone' => 'nullable|string|max:15',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar ?? null,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
        ]);

         // 2. Thêm vào bảng user_role (role mặc định = 0)
        DB::table('user_role')->insert([
        'user_id' => $user->id,
        'role_id' => 0,
        'created_at' => now(),
        'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

