<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    // Hiển thị danh sách bình luận (Admin)
    public function index()
    {
        $comments = Comment::with(['user', 'commentable'])->latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    // Duyệt bình luận
    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = true;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được duyệt.');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Bình luận đã bị xóa.');
    }

}
