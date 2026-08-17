<?php

namespace App\Http\Controllers\Shop;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;


class CartController extends Controller
{

    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $cart_total_price = 0;
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $price = $item['is_on_sale'] ? $item['sale_price'] : $item['price'];
                $cart_total_price += $price * $item['qty'];
            }
        }

        return view('cart.index', compact('cart', 'cart_total_price'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {

            if ($request->qty >= $product->quantity) {
                return redirect()->back()->with('error', 'تعداد محصول درخواستی بیش از حد مجاز است');
            }
            $cart[$product->id]['qty'] = $request->qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_on_sale' => $product->is_on_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'sale_percent' => $product->sale_percent,
                'primary_image' => $product->primary_image,
                'qty' => $request->qty
            ];
        }
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'محصول به سبد خرید اضافه شد');
    }

    public function increment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {

            if ($cart[$product->id]['qty'] >= $product->quantity) {
                return redirect()->back()->with('error', 'محصول با حداکثر تعداد به سبد خرید اضافه شده');
            }
            $cart[$product->id]['qty']++;
        } else {
            $cart[$product->id] = [
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
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'محصول به سبد خرید اضافه شد');
    }

    public function decrement(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {

            if ($cart[$product->id]['qty'] == 1) {
                unset($cart[$product->id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'محصول با موفقیت از سبد خرید حذف شد');
            }
            $cart[$product->id]['qty'] = $cart[$product->id]['qty'] - 1;
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('success', 'محصول از سبد خرید کم شد');
        } else {
            return redirect()->back()->with('error', 'محصول موردنظر در سبد خرید موجود نیست');
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'محصول با موفقیت از سبد خرید حذف شد');
        } else {
            return redirect()->back()->with('error', 'محصول موردنظر در سبد خرید موجود نیست');
        }
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('products.menu')->with('success', 'سبد خرید با موفقیت خالی شد.');
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->code)->where('expired_at', '>', Carbon::now())->first();
        if ($coupon == null) {
            return redirect()->route('cart.index')->withErrors(['code' => 'کدتخفیف واردشده معتبر نیست'])->withInput();;
        }

        $request->session()->put('coupon', ['code' => $coupon->code, 'percentage' => $coupon->percentage, 'expired_at' => $coupon->expired_at]);
        return redirect()->route('cart.index');
    }
}
