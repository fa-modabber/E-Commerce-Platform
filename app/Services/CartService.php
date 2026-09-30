<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use RuntimeException;

class CartService
{
    private const CART_KEY = 'cart';

    public function getCart(Request $request)
    {
        return $request->session()->get(self::CART_KEY, []);
    }

    public function calculateTotal($cart)
    {
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $price = $item['is_on_sale'] ? $item['sale_price'] : $item['price'];
                $cart_total_price += $price * $item['qty'];
            }
        }
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = $this->getCart($request);

        // if product is not in the cart
        if (!isset($cart[$product->id])) {
            $cart[$product->id] = $this->createCartItem($product);
        } else {
            if ($cart[$product->id]['qty'] >= $product->quantity) {
                throw new RuntimeException(
                    'تعداد محصول درخواستی بیش از حد مجاز است'
                );
            }

            $cart[$product->id]['qty']++;
        }

        $request->session()->put(self::CART_KEY, $cart);
    }

    public function removeFromCart(
        Request $request,
        Product $product
    ): bool {
        $cart = $this->getCart($request);

        if (!isset($cart[$product->id])) {
            throw new RuntimeException(
                'محصول موردنظر در سبد خرید موجود نیست'
            );
        }

        if ($cart[$product->id]['qty'] === 1) {
            unset($cart[$product->id]);
            $request->session()->put(self::CART_KEY, $cart);
            return true;
        }

        $cart[$product->id]['qty']--;
        $request->session()->put(self::CART_KEY, $cart);
        return false;
    }

    public function createCartItem(Product $product)
    {
        return [
            'name' => $product->name,
            'quantity' => $product->quantity,
            'is_on_sale' => $product->is_on_sale,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'sale_percent' => $product->sale_percent,
            'primary_image' => $product->primary_image,
            'qty' => 1
        ];
    }

    public function clearCart(Request $request): void
    {
        $request->session()->forget(self::CART_KEY);
    }

}
