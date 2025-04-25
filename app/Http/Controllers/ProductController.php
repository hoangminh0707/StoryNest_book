<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\categories;
use App\Models\Author;


class ProductController extends Controller
{



    public function index()
    {
        $products = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = categories::all();

        return view('client.pages.index', compact('products', 'categories'));
    }


    public function shop(Request $request)
    {
        $query = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ]);

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        $products = $query->paginate(12);



        $authors = Author::all();
        $categories = categories::all();

        return view('client.pages.shop', compact('products', 'categories', 'authors'));
    }



    public function show($id)
    {
        $products = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = categories::all();

        $product = Product::with(['author', 'categories', 'images'])->findOrFail($id);
        $thumbnail = $product->images->where('is_thumbnail', 1)->first();
        $otherImages = $product->images->where('is_thumbnail', false);

        return view('client.pages.product', compact('product', 'thumbnail', 'otherImages', 'products', 'Category'));

    }
    public function about()
    {
        return view('client.pages.about');
    }


}
