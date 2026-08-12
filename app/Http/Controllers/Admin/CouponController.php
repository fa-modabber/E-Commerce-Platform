<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    public function __construct(
        protected CouponService $couponService
    ) {}

    public function index(): View
    {
        $coupons = $this->couponService->all();

        return view(
            'Admin.coupons.index',
            compact('coupons')
        );
    }

    public function create(): View
    {
        return view('Admin.coupons.create');
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        //     try {
        //         $expired_at = $request->expired_at ? convert_jalali_to_gregorian_date($request->expired_at) : null;
        //     } catch (\Exception $e) {
        //         return redirect()->route('admin.coupons.create')->with('error', 'تاریخ انقضا صحیح نیست');
        //     }
        //     $request->merge([
        //         'expired_at' => $expired_at,
        //     ]);
        //     $request->validate([
        //         'expired_at' => 'required|date_format:Y-m-d H:i:s'
        //     ]);

        $this->couponService->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'کد تخفیف با موفقیت ایجاد شد');
    }

    public function edit(Coupon $coupon): View
    {
        return view(
            'Admin.coupons.edit',
            compact('coupon')
        );
    }

    public function update(
        UpdateCouponRequest $request,
        Coupon $coupon
    ): RedirectResponse {
        $this->couponService->update(
            $coupon,
            $request->validated()
        );

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'کد تخفیف با موفقیت آپدیت شد');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $this->couponService->destroy($coupon);

        return redirect()
            ->route('admin.coupons.index')
            ->with('warning', 'کد تخفیف با موفقیت حذف شد');
    }
}
