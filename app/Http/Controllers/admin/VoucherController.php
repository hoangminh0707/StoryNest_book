<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Danh sách voucher với tìm kiếm
     */
    public function index(Request $request)
    {
        $query = Voucher::query();
    
        if ($request->filled('keyword')) {
            $search = $request->keyword;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            });
        }
        
    
        $vouchers = $query->orderByDesc('created_at')->paginate(15);
        
    
        return view('admin.vouchers.index', compact('vouchers'));
    }
    

    /**
     * Form tạo mới voucher
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Lưu voucher mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'description' => 'nullable|string',
        ]);

        $data = $request->only([
            'code', 'name', 'type', 'value', 'max_usage', 'expires_at', 'description'
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Voucher::create($data);

        return redirect()->route('vouchers.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    /**
     * Form chỉnh sửa voucher
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Cập nhật voucher
     */
    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'description' => 'nullable|string',
        ]);

        $data = $request->only([
            'code', 'name', 'type', 'value', 'max_usage', 'expires_at', 'description'
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $voucher->update($data);

        return redirect()->route('vouchers.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Xoá voucher
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Xóa mã giảm giá thành công!');
    }

    /**
     * Bật/tắt trạng thái voucher
     */
    public function toggle(Voucher $voucher)
    {
        $voucher->is_active = !$voucher->is_active;
        $voucher->save();

        return redirect()->route('vouchers.index')->with('success', 'Cập nhật trạng thái thành công!');
    }
}
