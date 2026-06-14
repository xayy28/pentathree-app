@extends('layouts.user')

@section('title', 'Profile Saya')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-[32px] shadow-sm border border-[#E6E4DD] overflow-hidden">
            <div class="bg-[#F8F7F4] px-6 py-8 sm:px-12 sm:py-10">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="w-full max-w-[164px]">
                        <div
                            class="w-[164px] h-[164px] rounded-full overflow-hidden bg-[#EAF2EE] border border-[#DDE8DF] mx-auto">
                            @if ($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-3xl font-semibold text-[#2B4C3F]">
                                    {{ strtoupper(substr($user->nama, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 space-y-4 text-center lg:text-left">
                        <h1 class="text-3xl font-serif font-semibold text-[#2B4C3F]">Halo, {{ $user->nama }}</h1>
                        <p class="text-sm text-[#5C6E65] max-w-2xl">Kelola informasi akun Anda, perbarui data kontak, dan
                            unggah foto profil untuk membuat akun Anda lebih personal.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                            <a href="{{ route('profile.edit') }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-full bg-[#2B4C3F] text-white text-sm font-semibold hover:bg-[#25382f] transition">Edit
                                Profil</a>
                            <a href="{{ route('profile.password.edit') }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-full border border-[#D5D3C7] bg-white text-[#2C3E35] text-sm font-semibold hover:bg-[#F8F7F4] transition">Edit
                                Password</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-10 sm:px-12 sm:pb-12">
                <div class="grid gap-6 md:grid-cols-2 mt-8">
                    <div class="bg-[#FAF9F6] rounded-3xl border border-[#E6E4DD] p-6">
                        <h2 class="text-sm uppercase tracking-[0.2em] text-[#8A9C91] mb-5">Informasi Akun</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Nama</p>
                                <p class="text-sm text-[#2C3E35] font-semibold">{{ $user->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Email</p>
                                <p class="text-sm text-[#2C3E35]">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Nomor HP</p>
                                <p class="text-sm text-[#2C3E35]">{{ $user->no_hp }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Alamat</p>
                                <p class="text-sm text-[#2C3E35]">{{ $user->alamat }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#FAF9F6] rounded-3xl border border-[#E6E4DD] p-6">
                        <h2 class="text-sm uppercase tracking-[0.2em] text-[#8A9C91] mb-5">Detail Lainnya</h2>
                        <div class="space-y-4 text-sm text-[#2C3E35]">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">ID Pengguna</p>
                                <p>{{ $user->user_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Terdaftar pada</p>
                                <p>{{ $user->created_at?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#5C6E65] mb-1">Terakhir diperbarui</p>
                                <p>{{ $user->updated_at?->format('d M Y') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
