<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
<<<<<<< HEAD:app/Http/Controllers/Client/CommentClientController.php
use Illuminate\Support\Facades\Validator;
=======
use Validator;
>>>>>>> 3f05e77d06abcbb2e3e48cd6c37e4abf8e08c01e:app/Http/Controllers/Client/CommentController.php


class CommentClientController extends Controller
{
    // Lưu bình luận
    public function store(Request $request, $blog_id)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Kiểm tra xem bài viết có tồn tại không
        $blog = Blog::find($blog_id);
        if (!$blog) {
            return redirect()->route('blogs.index')->with('error', 'Bài viết không tồn tại!');
        }

        // Lưu bình luận
        Comment::create([
            'blog_id' => $blog_id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        // Trở lại bài viết với thông báo thành công
        return back()->with('success', 'Bình luận của bạn đã được gửi!');
    }
}