<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Hiển thị danh sách banner
    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    // Hiển thị form tạo banner mới
    public function create()
    {
        return view('admin.banners.create');
    }

    // Lưu banner mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpg,jpeg,png,gif',
            'link' => 'required|url',
            'order' => 'required|integer',
        ]);

        // Lưu hình ảnh lên storage
        $imagePath = $request->file('image_url')->store('banners', 'public');

        // Tạo banner mới
        Banner::create([
            'title' => $request->title,
            'image_url' => $imagePath,
            'link' => $request->link,
            'order' => $request->order,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner đã được tạo.');
    }

    // Hiển thị form chỉnh sửa banner
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'order' => 'required|integer',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->order = $request->order;

        // Nếu có hình ảnh mới, lưu nó
        if ($request->hasFile('image_url')) {
            // Xóa hình ảnh cũ
            Storage::disk('public')->delete($banner->image_url);

            // Lưu hình ảnh mới
            $imagePath = $request->file('image_url')->store('banners', 'public');
            $banner->image_url = $imagePath;
        }

        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner đã được cập nhật.');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Xóa hình ảnh liên quan
        Storage::disk('public')->delete($banner->image_url);

        // Xóa banner
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner đã được xóa.');
    }
}

