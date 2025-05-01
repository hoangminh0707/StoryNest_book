<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

        $hasPurchased = OrderItem::where('product_id', $request->product_id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())
                    ->where('status', 'completed'); // hoặc status 'success'
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->withErrors('Bạn chưa mua sản phẩm này.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Có thể đợi admin duyệt
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

}