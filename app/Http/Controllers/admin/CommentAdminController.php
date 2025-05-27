<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentAdminController extends Controller
{

    public function index(Request $request)
    {
        $commentsQuery = Comment::with('user', 'commentable')
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where('content', 'like', "%{$keyword}%")
                      ->orWhereHas('user', function ($uq) use ($keyword) {
                          $uq->where('name', 'like', "%{$keyword}%");
                      });
                });
            })
            ->when($request->has('is_approved') && $request->is_approved !== '', function ($query) use ($request) {
                $query->where('is_approved', (int) $request->input('is_approved'));
            })
            ->when($request->filled('commentable_type'), function ($query) use ($request) {
                $query->where('commentable_type', $request->input('commentable_type'));
            })
            ->latest()
            ->paginate(10);
    
        // Truyền $commentsQuery vào view thay vì $comments
        return view('admin.pages.comments.index', [
            'commentsQuery' => $commentsQuery
        ]);
    }
    
    // Hiển thị chi tiết 1 bình luận kèm các trả lời
    public function show($id)
    {
        $comment = Comment::with(['user', 'replies.user', 'commentable'])->findOrFail($id);
        return view('admin.pages.comments.show', compact('comment'));
    }

    // Chỉnh sửa bình luận
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('admin.pages.comments.edit', compact('comment'));
    }

    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);

        // Chỉ cho phép admin chỉnh sửa bình luận của admin, không phải người dùng
        if (auth()->check() && (auth()->user()->is_admin || $comment->user_id == auth()->id())) {
            $comment->content = $request->input('content');
            $comment->save();

            return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được cập nhật.');
        } else {
            return redirect()->route('admin.comments.index')->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }
    }

    // Duyệt bình luận
    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = true;
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được duyệt.');
    }

    // Hủy duyệt bình luận
    public function disapprove($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = false;
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã bị hủy duyệt.');
    }

    // Trả lời bình luận
    public function reply(Request $request, $commentId)
    {
        $request->validate([
            'reply_content' => 'required|string|max:1000',
        ]);

        $parent = Comment::findOrFail($commentId);

        $reply = new Comment();
        $reply->user_id = auth()->id();
        $reply->content = $request->input('reply_content');
        $reply->commentable_id = $parent->commentable_id;
        $reply->commentable_type = $parent->commentable_type;
        $reply->parent_id = $parent->id;
        $reply->is_approved = true; // auto duyệt admin trả lời
        $reply->save();

        return redirect()->back()->with('success', 'Đã trả lời bình luận.');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Xóa luôn các trả lời con (nếu có)
        Comment::where('parent_id', $comment->id)->delete();

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Xóa bình luận thành công.');
    }
}
