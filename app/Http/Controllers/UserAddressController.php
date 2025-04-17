<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    // UserAddressController.php
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        return view('client.pages.address', compact('addresses'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'address_line' => 'required',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ]);
    
        $user = auth()->user();
    
        // Nếu chọn là mặc định thì cập nhật các địa chỉ khác về 0
        if ($request->is_default) {
            $user->addresses()->update(['is_default' => 0]);
        }
    
        $user->addresses()->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'district' => $request->district,
            'ward' => $request->ward,
            'is_default' => $request->has('is_default'),
        ]);
    
        return redirect()->route('addresses.index')->with('success', 'Thêm địa chỉ thành công');
    }
    
    public function setDefault($id)
    {
        $user = auth()->user();
    
        $user->addresses()->update(['is_default' => 0]);
    
        $address = $user->addresses()->findOrFail($id);
        $address->update(['is_default' => 1]);
    
        return back()->with('success', 'Cập nhật địa chỉ mặc định thành công');
    }
    

}
