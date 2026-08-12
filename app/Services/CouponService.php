<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

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
}
