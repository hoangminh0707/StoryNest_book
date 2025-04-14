<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Hiển thị danh sách bài viết.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách bài viết, sắp xếp theo thứ tự mới nhất và phân trang
        $blogs = Blog::latest()->paginate(10);

        // Trả về view cùng với dữ liệu bài viết
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Hiển thị form tạo bài viết mới.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Trả về view tạo bài viết mới
        return view('admin.blogs.create');
    }

    /**
     * Lưu bài viết mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        // Lưu bài viết mới vào cơ sở dữ liệu
        Blog::create([
            'user_id' => Auth::id(), // Sử dụng ID người dùng đã đăng nhập (hoặc bạn có thể sử dụng 1 cho admin mặc định)
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        // Chuyển hướng về trang danh sách bài viết và thông báo thành công
        return redirect()->route('blogs.index')->with('success', 'Thêm bài viết thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa bài viết.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Lấy bài viết theo ID
        $blog = Blog::findOrFail($id);

        // Trả về view chỉnh sửa bài viết
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Cập nhật thông tin bài viết.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        // Tìm bài viết theo ID và cập nhật thông tin
        $blog = Blog::findOrFail($id);
        $blog->update([
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        // Chuyển hướng về trang danh sách bài viết và thông báo thành công
        return redirect()->route('blogs.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    /**
     * Xóa bài viết.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Tìm bài viết theo ID và xóa
        $blog = Blog::findOrFail($id);
        $blog->delete();

        // Chuyển hướng về trang danh sách bài viết và thông báo thành công
        return redirect()->route('blogs.index')->with('success', 'Xóa bài viết thành công.');
    }

    /**
     * Xóa nhiều bài viết cùng lúc.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function massDelete(Request $request)
    {
        // Xác thực mảng ID bài viết cần xóa
        $request->validate([
            'blogs' => 'required|array',
            'blogs.*' => 'exists:blogs,id', // Đảm bảo tất cả ID bài viết đều hợp lệ
        ]);

        // Xóa các bài viết theo ID trong mảng
        Blog::whereIn('id', $request->blogs)->delete();

        // Chuyển hướng về trang danh sách bài viết và thông báo thành công
        return redirect()->route('blogs.index')->with('success', 'Xóa các bài viết thành công.');
    }
}
