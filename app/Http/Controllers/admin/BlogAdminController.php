<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class BlogAdminController extends Controller
{

    public function index(): View
    {
        // Lấy danh sách bài viết, sắp xếp theo thứ tự mới nhất và phân trang
        $blogs = Blog::latest()->paginate(10);

        // Trả về view cùng với dữ liệu bài viết
        return view('admin.pages.blogs.index', compact('blogs'));
    }


    public function create(): View
    {
        // Trả về view tạo bài viết mới
        return view('admin.pages.blogs.create');
    }


    public function store(Request $request)
    {
        // Validating dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Kiểm tra ảnh
            'status' => 'required|in:draft,published', // Kiểm tra trạng thái bài viết
        ]);

        // Lưu ảnh lên thư mục public nếu có
        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url');
            $imagePath = $image_url->storeAs('blogs', Str::random(10) . '.' . $image_url->getClientOriginalExtension(), 'public');
        }

        // Lưu bài viết vào cơ sở dữ liệu
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->image_url = $imagePath; // Lưu đường dẫn ảnh
        $blog->status = $request->input('status');
        $blog->user_id = Auth::id(); // Lưu user_id
        $blog->save();

        // Chuyển hướng về danh sách bài viết với thông báo thành công
        return redirect()->route('admin.blogs.index')->with('success', 'Bài viết đã được thêm thành công.');
    }

    public function edit($id)
    {
        // Lấy bài viết theo ID
        $blog = Blog::findOrFail($id);

        // Trả về view chỉnh sửa bài viết
        return view('admin.pages.blogs.edit', compact('blog'));
    }


    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Lấy dữ liệu cần cập nhật
        $data = $request->only(['title', 'content', 'status']);

        // Nếu có ảnh mới, thay thế ảnh cũ
        if ($request->hasFile('image_url')) {
            // Xóa ảnh cũ nếu có
            if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
                Storage::disk('public')->delete($blog->image_url);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('image_url')->store('blogs', 'public');
            $data['image_url'] = $imagePath;
        }

        // Cập nhật bài viết
        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công!');
    }


    public function destroy($id)
    {
        // Tìm bài viết theo ID và xóa
        $blog = Blog::findOrFail($id);

        // Nếu có ảnh, xóa ảnh liên quan
        if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
            Storage::disk('public')->delete($blog->image_url);
        }

        // Xóa bài viết
        $blog->delete();

        // Chuyển hướng về trang danh sách bài viết và thông báo thành công
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa bài viết thành công.');
    }


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
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa các bài viết thành công.');
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/blogs', $filename, 'public');

            return response()->json([
                'url' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/blogs', $filename, 'public');

            return response()->json([
                'url' => Storage::url($path)
            ]);
        }
    }
}