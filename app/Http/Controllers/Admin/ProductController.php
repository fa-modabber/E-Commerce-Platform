<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(): View
    {
        $products = $this->productService->paginate();

        return view(
            'Admin.products.index',
            compact('products')
        );
    }

    public function show(Product $product): View
    {
        return view(
            'Admin.products.show',
            compact('product')
        );
    }

    public function create(): View
    {
        $categories = Category::all();

        return view(
            'Admin.products.create',
            compact('categories')
        );
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ایجاد شد');
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();

        return view(
            'Admin.products.edit',
            compact('product', 'categories')
        );
    }

    public function update(
        UpdateProductRequest $request,
        Product $product
    ): RedirectResponse {
        $this->productService->update(
            $product,
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ویرایش شد');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->destroy($product);

        return redirect()
            ->route('admin.products.index')
            ->with('warning', 'محصول با موفقیت حذف شد');
    }
}
