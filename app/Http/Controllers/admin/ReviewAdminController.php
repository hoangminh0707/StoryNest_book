<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pages.reviews.index', compact('reviews'));
    }

    // Hiển thị chi tiết đánh giá
    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.pages.reviews.show', compact('review'));
    }

    // Duyệt đánh giá
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được duyệt.');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã bị xóa.');
    }
}