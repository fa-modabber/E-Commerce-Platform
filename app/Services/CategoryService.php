<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function update(
        Category $category,
        array $data
    ): Category {
        $category->update($data);

        return $category->refresh();
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }
}