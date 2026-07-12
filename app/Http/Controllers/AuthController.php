<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role, tetapi jangan pakai intended URL yang beda area akses.
            if ($user->role === 'admin') {
                return redirect()->to($this->intendedUrlForRole($request, 'admin', '/admin/dashboard'))
                    ->with('success', 'Selamat datang kembali, Admin ' . $user->nama . '!');
            }

            return redirect()->to($this->intendedUrlForRole($request, 'user', '/dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Ambil intended URL hanya jika URL itu aman untuk role yang baru login.
     */
    private function intendedUrlForRole(Request $request, string $role, string $fallbackPath): string
    {
        $intendedUrl = $request->session()->pull('url.intended');

        if (! $intendedUrl) {
            return $fallbackPath;
        }

        $host = parse_url($intendedUrl, PHP_URL_HOST);
        if ($host && $host !== $request->getHost()) {
            return $fallbackPath;
        }

        $path = parse_url($intendedUrl, PHP_URL_PATH) ?: '/';
        if (in_array($path, ['/login', '/register'], true)) {
            return $fallbackPath;
        }

        $isAdminPath = $path === '/admin' || str_starts_with($path, '/admin/');

        if ($role === 'admin') {
            return $isAdminPath ? $intendedUrl : $fallbackPath;
        }

        return $isAdminPath ? $fallbackPath : $intendedUrl;
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru.
     */
    public function register(RegisterRequest $request)
    {
        // Membuat user baru. Password otomatis di-hash melalui cast model 'password' => 'hashed'.
        // user_id otomatis dibuat di event 'creating' pada model User.
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'user', // otomatis sebagai user
        ]);

        if (Schema::hasTable('roles')) {
            Role::findOrCreate('user', 'web');
            $user->assignRole('user');
        }

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Aura Stay & Style.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}