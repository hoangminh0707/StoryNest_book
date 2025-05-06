<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $role = Role::all();
        return view('admin.pages.user.listUser', compact('users'));
    }


    public function create()
    {
        return view('admin.pages.user.createUser');
    }

    public function add(Request $request)
{

    // Validation
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'gender' => 'required|in:male,female,other',
        'birthdate' => 'required|date',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

   
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'avatar' => $request->avatar ?? null,
        'gender' => $request->gender,
        'birthdate' => $request->birthdate,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    return redirect()->route('admin.userIndex')->with('success', 'Đăng ký thành công')->with('input', $input);
}

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.pages.user.editUser', compact('user', 'roles'));
    }



    public function update(Request $request, User $user)
{
    // Validation rules (loại bỏ email validation)
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id, // Đảm bảo email là duy nhất, ngoại trừ người dùng hiện tại
        'gender' => 'required|in:male,female,other',
        'birthdate' => 'required|date',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'roles' => 'required|array', // Thêm validation cho vai trò
        'roles.*' => 'exists:roles,id', // Đảm bảo mỗi vai trò tồn tại trong bảng roles
    ];

    if ($request->filled('password')) {
        $rules['password'] = 'nullable|string|min:8|confirmed';
    }

    $request->validate($rules);

    $data = [
        'name' => $request->name,
        'gender' => $request->gender,
        'birthdate' => $request->birthdate,
        'phone' => $request->phone,
        'address' => $request->address,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    // Cập nhật vai trò của người dùng
    $user->roles()->sync($request->roles);

    return redirect()->route('admin.userIndex')->with('success', 'User updated successfully.');
}
    



    
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.userIndex')->with('success', 'User deleted successfully.');
}


        }