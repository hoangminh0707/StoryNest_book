<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng + tìm kiếm
    public function index(Request $request)
    {
        $query = User::with('roles');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
    
        $users = $query->latest()->paginate(10); // phân trang 10 người dùng mỗi trang
    
        return view('admin.pages.user.listUser', compact('users'));
    }

    // Hiển thị form tạo người dùng
    public function create()
    {
        $roles = Role::all();
        return view('admin.pages.user.createUser', compact('roles'));
    }

    // Xử lý lưu người dùng mới
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gender'    => 'required|in:male,female,other',
            'birthdate' => 'required|date',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:255',
            'roles'     => 'required|array',
            'roles.*'   => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'email', 'gender', 'birthdate', 'phone', 'address']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.userIndex')->with('success', 'Người dùng đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.pages.user.editUser', compact('user', 'roles'));
    }

    // Cập nhật người dùng
    public function update(Request $request, User $user)
    {
        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'gender'    => 'required|in:male,female,other',
            'birthdate' => 'required|date',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:255',
            'roles'     => 'required|array',
            'roles.*'   => 'exists:roles,id',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'email', 'gender', 'birthdate', 'phone', 'address']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Cập nhật avatar nếu có
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.userIndex')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.userIndex')->with('success', 'Người dùng đã bị xóa.');
    }
}
