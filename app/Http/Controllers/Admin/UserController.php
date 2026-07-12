<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $roles = ['admin', 'user'];

        $users = User::when(in_array($role, $roles, true), fn ($query) => $query->where('role', $role))
            ->latest()
            ->get();

        $totalAdmin = User::where('role', 'admin')->count();
        $totalUser = User::where('role', 'user')->count();
        $totalVerifikasi = User::whereNotNull('email_verified_at')->count();

        return view('admin.user.index', compact('users', 'role', 'roles', 'totalAdmin', 'totalUser', 'totalVerifikasi'));
    }
}
