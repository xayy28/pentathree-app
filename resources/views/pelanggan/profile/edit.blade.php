@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 lg:grid-cols-[1.25fr_0.9fr]">
            <div class="bg-white rounded-[32px] border border-[#E6E4DD] shadow-sm p-8">
                <div class="flex items-center justify-between gap-6 mb-8">
                    <div>
                        <h1 class="text-3xl font-serif font-semibold text-[#2B4C3F]">Edit Profil</h1>
                        <p class="text-sm text-[#5C6E65] mt-1">Perbarui data akun dan informasi kontak Anda.</p>
                    </div>
                    <a href="{{ route('profile.show') }}"
                        class="inline-flex items-center justify-center rounded-full border border-[#D5D3C7] px-4 py-2 text-sm font-semibold text-[#2C3E35] hover:bg-[#F8F7F4] transition">Lihat
                        Profil</a>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nama"
                                class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Nama
                                Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                required
                                class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                            @error('nama')
                                <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email"
                                class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required
                                class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                            @error('email')
                                <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="no_hp"
                                class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Nomor
                                HP</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                required
                                class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                            @error('no_hp')
                                <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="alamat"
                                class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="foto_profil"
                                class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Foto
                                Profil</label>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-20 h-20 rounded-full overflow-hidden bg-[#EAF2EE] border border-[#DDE8DF] flex items-center justify-center">
                                    @if ($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                                            class="w-full h-full object-cover">
                                    @else
                                        <span
                                            class="text-lg font-semibold text-[#2B4C3F]">{{ strtoupper(substr($user->nama, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="foto_profil" id="foto_profil"
                                        class="w-full text-sm text-[#2C3E35] file:rounded-full file:border-0 file:bg-[#EAF2EE] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#2B4C3F]"
                                        accept="image/jpeg,image/png,image/jpg,image/webp">
                                    @error('foto_profil')
                                        <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-full bg-[#2B4C3F] px-6 py-3 text-sm font-semibold text-white hover:bg-[#25382f] transition">Simpan
                        Perubahan Profil</button>
                </form>
            </div>

            <div class="bg-white rounded-[32px] border border-[#E6E4DD] shadow-sm p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-serif font-semibold text-[#2B4C3F]">Ubah Password</h1>
                    <p class="text-sm text-[#5C6E65] mt-1">Ganti password Anda secara berkala untuk menjaga keamanan akun.
                    </p>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Password Saat
                            Ini</label>
                        <input type="password" name="current_password" id="current_password"
                            value="{{ old('current_password') }}" required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                        @error('current_password')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Password
                            Baru</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                        @error('password')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Konfirmasi
                            Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            value="{{ old('password_confirmation') }}" required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                    </div>

                    <button type="submit"
                        class="w-full rounded-full bg-[#2B4C3F] px-6 py-3 text-sm font-semibold text-white hover:bg-[#25382f] transition">Perbarui
                        Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
