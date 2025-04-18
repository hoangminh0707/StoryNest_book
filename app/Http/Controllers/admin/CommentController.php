<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    // Hiển thị danh sách bình luận với tìm kiếm và phân trang
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'commentable']);

        if ($search = $request->input('search')) {
            $query->where('content', 'like', "%{$search}%");
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pages.comments.index', compact('comments'));
    }

    // Duyệt bình luận
    public function approve($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Không tìm thấy bình luận.');
        }

        $comment->is_approved = true;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được duyệt.');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Không tìm thấy bình luận.');
        }

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã bị xóa.');
    }
}