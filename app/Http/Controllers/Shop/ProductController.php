<?php

namespace App\Http\Controllers\Shop;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;


class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function show(Product $product): View
    {
        $randomProducts = $this->productService
            ->randomAvailableProducts();

        return view(
            'products.show',
            compact('product', 'randomProducts')
        );
    }

    public function menu(Request $request)
    {
        $categories = Category::all();

        $filters = [
            'category' => $request->category,
            'is_available' => $request->is_available,
            'sort' => $request->sort
        ];
        
        $products = $this->productService->searchProducts(
            $request->search,
            $request->filters(),
        );
        return view(
            'products.menu',
            compact(
                'products',
                'categories'
            )
        );
    }
}
