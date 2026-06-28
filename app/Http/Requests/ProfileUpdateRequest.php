<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->user_id, 'user_id'),
            ],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'foto_profil.image' => 'File foto profil harus berupa gambar.',
            'foto_profil.mimes' => 'Foto profil hanya boleh berformat jpeg, png, jpg, atau webp.',
            'foto_profil.max' => 'Ukuran foto profil maksimal 2MB.',
        ];
    }
}
