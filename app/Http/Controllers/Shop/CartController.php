<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Cart\AddToCartRequest;
use App\Http\Requests\Shop\Cart\CartProductRequest;
use App\Http\Requests\Shop\Cart\CheckCouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CouponService $couponService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $cart_total_price = $this->cartService->calculateTotal($cart);

        return view('cart.index', compact(
            'cart',
            'cart_total_price'
        ));
    }

    public function add(AddToCartRequest $request)
    {
        $product = Product::findOrFail(
            $request->validated('product_id')
        );

        $this->cartService->addToCart(
            $request->validated(),
            $product
        );

        return redirect()
            ->back()
            ->with('success', 'محصول به سبد خرید اضافه شد');
    }

    public function decrement(CartProductRequest $request)
    {

        $product = Product::findOrFail(
            $request->validated('product_id')
        );

        $removed = $this->cartService->removeFromCart(
            $request->validated(),
            $product
        );

        return back()->with(
            'success',
            $removed
                ? 'محصول با موفقیت از سبد خرید حذف شد'
                : 'محصول از سبد خرید کم شد'
        );
    }

    public function clear(Request $request)
    {
        $this->cartService->clearCart($request);

        return redirect()
            ->route('products.menu')
            ->with('success', 'سبد خرید با موفقیت خالی شد.');
    }

    public function checkCoupon(CheckCouponRequest $request)
    {
        $this->couponService->apply(
            $request,
            $request->validated('code')
        );
        return redirect()->route('cart.index');
    }
}
