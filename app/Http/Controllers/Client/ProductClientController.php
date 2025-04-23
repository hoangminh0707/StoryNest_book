<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Author;


class ProductClientController extends Controller
{



    public function index()
    {
        $products = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = Category::all();

        return view('client.pages.index', compact('products', 'categories'));
    }


    public function shop(Request $request)
    {
        $query = Product::with([
            'author',
            'categories',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ]);

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }


        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }



        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        $products = $query->paginate(12);



        $authors = Author::all();
        $categories = Category::all();

        return view('client.pages.shop', compact('products', 'categories', 'authors'));
    }



    public function show($id)
    {
        $products = Product::with([
            'author',
            'categories', // thêm dòng này để load danh mục của sản phẩm
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = Category::all();

        $product = Product::with(['author', 'categories', 'images'])->findOrFail($id);

        $thumbnail = $product->images->where('is_thumbnail', 1)->first();
        $otherImages = $product->images->where('is_thumbnail', false);

        return view('client.pages.product', compact('product', 'thumbnail', 'otherImages', 'products', 'categories'));

    }


}