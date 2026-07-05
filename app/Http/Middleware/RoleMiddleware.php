<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user sesuai
        if (! $this->userHasRole($user, $role)) {
            // Redirect cerdas ke dashboard masing-masing jika salah masuk
            if ($this->userHasRole($user, 'admin')) {
                return redirect('/admin/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            }

            return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        return $next($request);
    }

    private function userHasRole($user, string $role): bool
    {
        if (method_exists($user, 'hasRole') && Schema::hasTable('roles') && Schema::hasTable('model_has_roles')) {
            try {
                if ($user->hasRole($role)) {
                    return true;
                }
            } catch (Throwable) {
                // Fallback ke kolom legacy agar data lama tetap bisa login.
            }
        }

        return $user->role === $role;
    }
}
