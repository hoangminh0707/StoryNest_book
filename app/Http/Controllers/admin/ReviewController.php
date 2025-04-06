<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    // Phê duyệt đánh giá
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        return redirect()->route('reviews.index')->with('success', 'Đánh giá đã được phê duyệt.');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Đánh giá đã được xóa.');
    }
}
