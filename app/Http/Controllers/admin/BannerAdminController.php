<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerAdminController extends Controller
{
    // Hiển thị danh sách banner
    public function index()
    {
        $banners = Banner::paginate(10);  // Sử dụng phân trang để hiển thị 10 banner mỗi trang
        return view('admin.pages.banners.index', compact('banners'));
    }

    // Hiển thị form tạo banner mới
    public function create()
    {
        return view('admin.pages.banners.create');
    }

    // Lưu banner mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->order = $request->order;

        // Lưu ảnh vào thư mục public/storage
        if ($request->hasFile('image')) {
            $banner->image_url = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được tạo thành công.');
    }

    // Hiển thị form sửa banner
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.pages.banners.edit', compact('banner'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->order = $request->order;

        // Nếu có ảnh mới, lưu ảnh vào thư mục public/storage và cập nhật
        if ($request->hasFile('image')) {
            $banner->image_url = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật thành công.');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa thành công.');
    }

    // Cập nhật trạng thái (hiển thị/ẩn) của banner
    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = !$banner->status;  // Đảo trạng thái (bật/tắt)
        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật trạng thái thành công!');
    }


    // Xóa nhiều banner cùng lúc
    // public function bulkDelete(Request $request)
    // {
    //     // Kiểm tra rằng các ID đã được truyền trong request
    //     $request->validate([
    //         'ids' => 'required|array|min:1',
    //         'ids.*' => 'exists:banners,id', // Kiểm tra rằng mỗi ID tồn tại trong bảng banners
    //     ]);

    //     // Cập nhật trạng thái của các banner được chọn, ví dụ: trạng thái is_deleted thành 1
    //     Banner::whereIn('id', $request->ids)->delete(); // Hoặc update trạng thái nếu cần

    //     return redirect()->route('admin.banners.index')->with('success', 'Xóa các banner đã chọn thành công!');
    // }

}