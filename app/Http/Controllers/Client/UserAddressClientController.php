<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserAddress;

class UserAddressClientController extends Controller
{
    // UserAddressController.php
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        return view('client.pages.profile.address', compact('addresses'));
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


    public function edit($id)
    {
        $address = UserAddress::findOrFail($id);
        return view('client.pages.profile.address-edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = UserAddress::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string|max:255',
            'city' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
        ]);

        $address->update($validated);
        return redirect()->route('addresses.index')->with('success', 'Đã cập nhật địa chỉ thành công.');
    }

    public function destroy($id)
    {
        $address = UserAddress::findOrFail($id);

        if ($address->orders()->exists()) {
            return redirect()->back()->with('error', 'Không thể xoá địa chỉ đã được dùng để đặt hàng.');
        }

        $address->delete();

        return redirect()->back()->with('success', 'Xoá địa chỉ thành công.');
    }

}