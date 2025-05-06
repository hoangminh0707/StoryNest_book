<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Order;
use App\Models\OrderItem;



class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Bạn chưa đăng nhập');
        }

        
        $totalSpent = Order::where('user_id', $user->id)
        ->where('status', 'confirmed')
        ->sum('total_amount');

        $totalProducts = OrderItem::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('status', 'confirmed');
        })->sum('quantity');

        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->count();

        return view('client.pages.profile.index', compact('user', 'totalSpent', 'totalProducts', 'completedOrders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cập nhật thông tin cơ bản
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;

        if ($request->hasFile('avatar')) {
            // Làm sạch email để dùng làm tên file (vd: user-email-com)
            $cleanEmail = Str::slug($user->email);
        
            // Lấy phần mở rộng của file (jpg, png, ...)
            $extension = $request->file('avatar')->getClientOriginalExtension();
        
            // Tạo tên file mới (ví dụ: user-email-com.jpg)
            $filename = "{$cleanEmail}.{$extension}";
        
            // Đường dẫn lưu trữ trong thư mục storage/app/public/avatars
            $pathInStorage = "avatars/{$filename}";
        
            // Lưu file (storeAs tự tạo file vào storage/app/public/avatars)
            $request->file('avatar')->storeAs('avatars', $filename);
        
            // Nếu user đã có avatar cũ, xóa file cũ đi
            if ($user->avatar && $user->avatar !== $pathInStorage && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
        
            // Lưu tên file mới vào database (avatar = 'avatars/...')
            $user->avatar = $pathInStorage;
            $user->save();
        }
        

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }



    public function showChangeEmailForm()
{
    $user = Auth::user();
    
    if (!$user->can_change_email) {
        return redirect()->route('profile.index')->with('error', 'Bạn chỉ được đổi email một lần.');
    }

    return view('client.pages.profile.change-email', compact('user'));
}

public function changeEmail(Request $request)
{
    $user = Auth::user();

    if (!$user->can_change_email) {
        return redirect()->route('profile.index')->with('error', 'Bạn không còn quyền đổi email.');
    }

    $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $user->email = $request->email;
    $user->email_verified_at = null;
    $user->can_change_email = false;
    $user->save();

    // Gửi lại email xác minh
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
    );

    Mail::raw("Xác minh email của bạn: $verificationUrl", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Xác minh địa chỉ email');
    });

    return redirect()->route('profile.index')->with('success', 'Email đã được cập nhật và email xác minh đã được gửi.');
}


  // Hiển thị form đổi mật khẩu
  public function showChangePasswordForm()
  {
      return view('client.pages.profile.change-password');
  }

  // Xử lý đổi mật khẩu
  public function changePassword(Request $request)
  {
      $request->validate([
          'current_password' => ['required'],
          'new_password' => ['required', 'min:8', 'confirmed'],
      ]);

      $user = Auth::user();

      // Kiểm tra mật khẩu hiện tại
      if (!Hash::check($request->current_password, $user->password)) {
          return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
      }

      // Cập nhật mật khẩu mới
      $user->password = Hash::make($request->new_password);
      $user->save();

      return back()->with('success', 'Đổi mật khẩu thành công!');
  }


}
