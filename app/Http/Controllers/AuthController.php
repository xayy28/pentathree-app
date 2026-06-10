<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Selamat datang kembali, Admin ' . $user->nama . '!');
            }

            return redirect()->intended('/dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
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
