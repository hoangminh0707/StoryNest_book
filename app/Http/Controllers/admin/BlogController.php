<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{


    // Hiển thị danh sách bài viết
    public function index()
    {
        $blogs = Blog::with('user')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    // Hiển thị form tạo bài viết
    public function create()
    {
        return view('admin.blogs.create');
    }

    // Lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        // Tạo bài viết mới
        Blog::create([
            'user_id' => auth()->id(),  // Lấy ID người dùng đang đăng nhập
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        // Chuyển hướng về trang quản lý bài viết với thông báo thành công
        return redirect()->route('blogs.index')->with('success', 'Bài viết đã được tạo.');
    }


    // Hiển thị form chỉnh sửa bài viết
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    // Cập nhật bài viết
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Bài viết đã được cập nhật.');
    }

    // Xóa bài viết
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Bài viết đã bị xóa.');
    }
}
