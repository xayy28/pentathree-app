<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pelanggan.profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function edit()
    {
        return view('pelanggan.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function editPassword()
    {
        return view('pelanggan.profile.password', [
            'user' => Auth::user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request, ImageUploadService $imageUploadService)
    {
        $user = Auth::user();
        $validated = $request->validated();

        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $validated['foto_profil'] = $imageUploadService->storeDisk(
                $request->file('foto_profil'),
                'uploads/foto_profil',
                maxWidth: 640,
                maxHeight: 640
            );
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini tidak cocok.',
                ])
                ->withInput();
        }

        $user->password = $request->password;
        $user->save();

        $request->session()->regenerateToken();

        return redirect()->route('profile.password.edit')->with('success', 'Password berhasil diubah.');
    }
}
