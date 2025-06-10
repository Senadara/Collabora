<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        // Debug: Log semua data yang masuk
        Log::info('Reset Password Attempt', [
            'email' => $request->email,
            'token' => $request->token,
            'has_password' => !empty($request->password),
            'has_password_confirmation' => !empty($request->password_confirmation)
        ]);

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        Log::info('Validation passed');

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                Log::info('Password reset callback executed for user: ' . $user->email);
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        Log::info('Password reset status: ' . $status);

         if ($status == Password::PASSWORD_RESET) {
            Log::info('Password reset successful, redirecting to login');
            return back()->with('success', 'Password berhasil direset!');
        }

        Log::error('Password reset failed with status: ' . $status);
        return back()->with('error', __($status));
    }
}