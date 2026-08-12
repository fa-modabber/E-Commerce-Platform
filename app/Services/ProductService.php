<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function paginate(int $perPage = 4): LengthAwarePaginator
    {
        return Product::paginate($perPage);
    }

    public function store(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $primaryImageName = $this->storeImage(
                $data['primary_image']
            );

            $product = Product::create([
                'slug' => $this->makeSlug($data['name']),
                'primary_image' => $primaryImageName,
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'status' => $data['status'],
                'sale_price' => $data['sale_price'] ?? 0,
                'sale_date_from' => $data['sale_date_from'] ?? null,
                'sale_date_to' => $data['sale_date_to'] ?? null,
            ]);

            $this->storeAdditionalImages(
                $product,
                $data['images'] ?? []
            );

            return $product->refresh();
        });
    }

    public function update(
        Product $product,
        array $data
    ): Product {
        return DB::transaction(function () use ($product, $data) {

            $attributes = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'status' => $data['status'],
                'sale_price' => $data['sale_price'] ?? 0,
                'sale_date_from' => $data['sale_date_from'] ?? null,
                'sale_date_to' => $data['sale_date_to'] ?? null,
            ];

            if ($product->name !== $data['name']) {
                $attributes['slug'] = $this->makeSlug(
                    $data['name']
                );
            }

            if (!empty($data['primary_image'])) {
                $this->deleteImage($product->primary_image);

                $attributes['primary_image'] =
                    $this->storeImage($data['primary_image']);
            }

            $product->update($attributes);

            if (!empty($data['images'])) {
                $this->deleteAdditionalImages($product);

                $this->storeAdditionalImages(
                    $product,
                    $data['images']
                );
            }

            return $product->refresh();
        });
    }

    public function destroy(Product $product): void
    {
        DB::transaction(function () use ($product) {

            $this->deleteImage($product->primary_image);

            foreach ($product->images as $image) {
                $this->deleteImage($image->name);
                $image->delete();
            }

            $product->delete();
        });
    }

    private function makeSlug(string $name): string
    {
        $slug = slugify($name);

        $count = Product::whereRaw(
            "slug RLIKE '^{$slug}(-[0-9]+)?$'"
        )->count();

        return $count
            ? "{$slug}-{$count}"
            : $slug;
    }

    private function storeImage(UploadedFile $image): string
    {
        $name = uniqid() . '-' . $image->getClientOriginalName();

        $image->storeAs(
            'images/products',
            $name
        );

        return $name;
    }

    private function storeAdditionalImages(
        Product $product,
        array $images
    ): void {
        foreach ($images as $image) {
            $name = $this->storeImage($image);

            ProductImage::create([
                'product_id' => $product->id,
                'name' => $name,
            ]);
        }
    }

    private function deleteAdditionalImages(Product $product): void
    {
        foreach ($product->images as $image) {
            $this->deleteImage($image->name);
            $image->delete();
        }
    }

    private function deleteImage(?string $name): void
    {
        if ($name) {
            Storage::delete(
                'images/products/' . $name
            );
        }
    }
}
