<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     * Memblokir akses ke fitur tertentu jika email belum diverifikasi.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json(
                    ['message' => 'Email Anda belum diverifikasi. Silakan verifikasi email Anda terlebih dahulu.'],
                    Response::HTTP_FORBIDDEN
                );
            }

            return redirect()->route('verification.notice')
                ->with('warning', 'Anda perlu memverifikasi email sebelum mengakses fitur ini.');
        }

        return $next($request);
    }
}
