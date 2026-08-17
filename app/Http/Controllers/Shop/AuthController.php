<?php

namespace App\Http\Controllers\Shop;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\LoginRequest;
use App\Http\Requests\Shop\ResendOtpRequest;
use App\Http\Requests\Shop\VerifyOtpRequest;
use App\Services\ShopAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected ShopAuthService $authService
    ) {}

    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $loginToken = $this->authService->sendLoginOtp(
            $request->validated('cellphone')
        );

        return response()->json([
            'login_token' => $loginToken,
        ]);
    }

    public function checkOtp(
        VerifyOtpRequest $request
    ): JsonResponse {
        $this->authService->verifyOtp(
            $request->validated('login_token'),
            $request->validated('otp')
        );

        return response()->json([
            'message' => 'ورود با موفقیت انجام شد',
        ]);
    }

    public function resendOtp(
        ResendOtpRequest $request
    ): JsonResponse {
        $loginToken = $this->authService->resendOtp(
            $request->validated('login_token')
        );

        return response()->json([
            'login_token' => $loginToken,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
