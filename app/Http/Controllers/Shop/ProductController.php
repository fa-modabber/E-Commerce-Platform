<?php

namespace App\Http\Controllers\Shop;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    public function show(Product $product)
    {
        $randomProducts = Product::available()->get()->random(4);
        return view('products.show', compact('product', 'randomProducts'));
    }

    public function menu(Request $request)
    {
        $categories = Category::all();
        $filters = [
            'category' => $request->category,
            'is_available' => $request->is_available,
            'sort' => $request->sort
        ];
        $products = Product::search($request->search)->filter($filters)->paginate(6);
        return view('products.menu', compact('products', 'categories'));
    }
}
