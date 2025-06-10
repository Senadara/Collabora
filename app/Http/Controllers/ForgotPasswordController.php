<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        Log::info('🔍 Mulai proses reset password');

        $request->validate(['email' => 'required|email']);

        Log::info('✅ Email tervalidasi', $request->only('email'));

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        Log::info('📤 Status reset link:', ['status' => $status]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}