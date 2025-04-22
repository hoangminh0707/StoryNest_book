<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogControllerClient extends Controller
{
    /**
     * API: Trả về danh sách các bài viết (JSON)
     */
    public function index()
    {
        // Lấy danh sách blog với các cột id, user_id, title, content, status và phân trang 8 bản ghi mỗi trang
        $blogs = Blog::select('id', 'user_id', 'title', 'content', 'status')->paginate(8);

        // Trả về view và truyền dữ liệu blogs vào
        return view('client.pages.blog', compact('blogs'));
    }
    public function show($id)
    {
        $blog = Blog::findOrFail($id); // Tìm blog theo ID, nếu không có sẽ trả 404

        return view('client.pages.post', compact('blog'));
    }
}