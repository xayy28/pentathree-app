<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Tampilkan halaman notifikasi verifikasi email.
     * Route: GET /email/verify (verification.notice)
     */
    public function notice()
    {
        // Jika sudah terverifikasi, redirect ke dashboard
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Proses link verifikasi dari email (Signed URL).
     * Route: GET /email/verify/{id}/{hash} (verification.verify)
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = auth()->user();

        // Pastikan ID cocok dengan user yang login
        if ($user->getKey() != $id) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        // Pastikan hash cocok
        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        // Pastikan signature URL valid
        if (! $request->hasValidSignature()) {
            abort(403, 'Link verifikasi telah kedaluwarsa atau tidak valid.');
        }

        // Jika sudah terverifikasi, redirect langsung
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('success', 'Email Anda sudah terverifikasi sebelumnya.');
        }

        // Tandai email sebagai terverifikasi
        $user->markEmailAsVerified();

        return redirect()->route('dashboard')
            ->with('success', 'Email Anda berhasil diverifikasi! Selamat menikmati semua fitur Natasha Homestay.');
    }

    /**
     * Kirim ulang email verifikasi.
     * Route: POST /email/verification-notification (verification.send)
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('status', 'Email verifikasi telah dikirim! Silakan periksa inbox Anda.');
    }
}
