<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ShopAuthService
{
    private function createOtp()
    {
        return (string) mt_rand(100000, 999999);
    }

    private function createLoginToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function sendLoginOtp(string $cellphone): string
    {
        $user = User::firstOrCreate(
            ['cellphone' => $cellphone]
        );

        $otp = $this->createOtp();

        $loginToken = $this->createLoginToken();

        $user->update([
            'otp' => $otp,
            'login_token' => $loginToken,
        ]);

        send_otp_sms(
            $user->cellphone,
            $otp,
            'test'
        );

        return $loginToken;
    }

    public function verifyOtp(string $loginToken, string $otp)
    {
        $user = User::query()
            ->where('login_token', $loginToken)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login_token' => ['توکن ورود نامعتبر است.'],
            ]);
        }

        if ($user->otp !== $otp) {
            throw ValidationException::withMessages([
                'otp' => ['کد ورود نادرست است.'],
            ]);
        }

        Auth::login($user, $remember = true);

        $user->update([
            'otp' => null,
            'login_token' => null,
        ]);
    }

     public function resendOtp(string $loginToken): string
    {
        $user = User::query()
            ->where('login_token', $loginToken)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login_token' => ['توکن ورود نامعتبر است.'],
            ]);
        }

        $otp = $this->createOtp();

        $newLoginToken = $this->createLoginToken();

        $user->update([
            'otp' => $otp,
            'login_token' => $newLoginToken,
        ]);

        send_otp_sms(
            $user->cellphone,
            $otp,
            'test'
        );

        return $newLoginToken;
    }
}
