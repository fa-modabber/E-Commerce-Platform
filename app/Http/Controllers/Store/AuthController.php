<?php

namespace App\Http\Controllers\Store;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/']
        ]);

        try {
            $user = User::where('cellphone', $request->cellphone)->first();
            $otpCode = mt_rand(100000, 999999);
            $loginToken = Hash::make('hrlrfoj#@9985jjfk;rgjljdf');
            if ($user) {
                $user->update([
                    'otp' => $otpCode,
                    'login_token' => $loginToken
                ]);
            } else {
                $user = User::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $otpCode,
                    'login_token' => $loginToken
                ]);
            }
            $response = send_otp_sms($user->cellphone, $otpCode, $template = "test");

            return response()->json(['login_token' => $loginToken, 'response' => $response], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function check_otp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'login_token' => 'required|string'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();
            if ($user->otp == $request->otp) {
                Auth::login($user, $remember = true);
                return response()->json(['message' => 'ورود با موفقیت انجام شد'], 200);
            } else {
                return response()->json(['message' => 'کد ورود نادرست است'], 422);
            }
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function resend_otp(Request $request)
    {
        $request->validate([
            'login_token' => 'required|string'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();
            $otpCode = mt_rand(100000, 999999);
            $loginToken = Hash::make('hrlrfoj#@9985jjfk;rgjljdf');
            $user->update([
                'otp' => $otpCode,
                'login_token' => $loginToken
            ]);
            $response = send_otp_sms($user->cellphone, $otpCode, $template = "test");


            return response()->json(['login_token' => $loginToken, 'response' => $response], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
