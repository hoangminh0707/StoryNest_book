<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\OrderItem;

class ReviewCLientController extends Controller
{


    public function store(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // ✅ Kiểm tra đã từng mua sản phẩm này chưa
        $hasPurchased = OrderItem::where('product_id', $request->product_id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())
                    ->whereIn('status', ['delivered', 'completed']);
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->withErrors('Bạn chưa mua sản phẩm này.');
        }

        // ✅ Kiểm tra đã từng đánh giá chưa
        $hasReviewed = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($hasReviewed) {
            return redirect()->back()->withErrors('Bạn đã đánh giá sản phẩm này rồi.');
        }

        // ✅ Lưu đánh giá
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Chờ duyệt nếu cần
        ]);

        Log::info('REVIEW_FORM_SUBMIT', [
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'passed_validate' => true,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }


}
