<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman request link reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses pengiriman link reset password ke email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
        ]);

        // Mengirimkan email menggunakan Password Broker bawaan Laravel
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
