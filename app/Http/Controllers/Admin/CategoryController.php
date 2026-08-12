<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->all();

        return view(
            'Admin.categories.index',
            compact('categories')
        );
    }

    public function create(): View
    {
        return view('Admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'دسته بندی با موفقیت ایجاد شد');
    }

    public function edit(Category $category): View
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): RedirectResponse {
        $this->categoryService->update(
            $category,
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'دسته بندی با موفقیت آپدیت شد');
    }

     public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->destroy($category);

        return redirect()
            ->route('admin.categories.index')
            ->with('warning', 'دسته بندی با موفقیت حذف شد');
    }
}
