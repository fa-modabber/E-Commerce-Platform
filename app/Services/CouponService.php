<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class CouponService
{
    public function all(): Collection
    {
        return Coupon::all();
    }

    public function store(array $data): Coupon
    {
        $data['expired_at'] = $this->convertExpirationDate(
            $data['expired_at']
        );

        return Coupon::create($data);
    }

    public function update(
        Coupon $coupon,
        array $data
    ): Coupon {
        $data['expired_at'] = $this->convertExpirationDate(
            $data['expired_at']
        );

        $coupon->update($data);

        return $coupon->refresh();
    }

    public function destroy(Coupon $coupon): void
    {
        $coupon->delete();
    }

    private function convertExpirationDate(string $date): string
    {
        try {
            return convert_jalali_to_gregorian_date($date);
        } catch (\Throwable) {
            throw ValidationException::withMessages([
                'expired_at' => ['تاریخ انقضا صحیح نیست.'],
            ]);
        }
    }

    private const COUPON_KEY = 'coupon';

    public function apply(
        Request $request,
        string $code
    ): void {
        $coupon = Coupon::query()
            ->where('code', $code)
            ->where('expired_at', '>', now())
            ->first();

        if (!$coupon) {
            throw ValidationException::withMessages([
                'code' => 'کد تخفیف واردشده معتبر نیست.',
            ]);
        }

        $request->session()->put(
            self::COUPON_KEY,
            [
                'code' => $coupon->code,
                'percentage' => $coupon->percentage,
                'expired_at' => $coupon->expired_at,
            ]
        );
    }
}
