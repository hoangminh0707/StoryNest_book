<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthClientController extends Controller
{
    public function showLogin()
    {
        return view('client.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }


    public function showRegister()
    {
        return view('client.pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'gender' => 'required|in:male,female,other',
        'birthdate' => 'required|date',
        'phone' => 'nullable|string|max:12',
        'newsletter' => 'accepted', 
    ], [
        'name.required' => 'Vui lòng nhập họ và tên.',
        'name.string' => 'Họ và tên không hợp lệ.',
        'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Định dạng email không hợp lệ.',
        'email.unique' => 'Email đã được sử dụng.',

        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

        'gender.required' => 'Vui lòng chọn giới tính.',
        'gender.in' => 'Giới tính không hợp lệ.',

        'birthdate.required' => 'Vui lòng nhập ngày sinh.',
        'birthdate.date' => 'Ngày sinh không hợp lệ.',

        'phone.string' => 'Số điện thoại không hợp lệ.',
        'phone.max' => 'Số điện thoại không được dài quá 15 ký tự.',

        'newsletter.accepted' => 'Bạn cần đồng ý đăng kí để tiếp tục.',
    ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar ?? null,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
        ]);

        // 2. Thêm vào bảng user_role (role mặc định = 0)
        DB::table('user_role')->insert([
            'user_id' => $user->id,
            'role_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
   public function showLinkRequestForm()
    {
        return view('client.pages.auth.password_request');
    }

    // Gửi email chứa link reset
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Hiển thị form nhập mật khẩu mới
    public function showResetForm(Request $request, $token)
    {
        return view('client.pages.auth.password_reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Xử lý cập nhật mật khẩu mới
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu tối thiểu 8 ký tự.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}