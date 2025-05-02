<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;



class CommentClientController extends Controller
{
    // Lưu bình luận
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
        ]);

        Comment::create([
            'user_id' => auth()->id() ?? null,
            'parent_id' => $request->parent_id,
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'content' => $request->content,
            'is_approved' => true // hoặc false nếu cần kiểm duyệt
        ]);

        return back()->with('success', 'Comment posted!');
    }
}