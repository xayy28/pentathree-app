@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-8">
        <div class="bg-gradient-to-r from-[#2B4C3F] to-[#1E362C] rounded-2xl p-6 sm:p-10 text-white shadow-md relative overflow-hidden">
            <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-10 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-white to-transparent pointer-events-none"></div>
            <h1 class="text-3xl sm:text-4xl font-serif font-semibold mb-3">
                Dashboard Overview
            </h1>
            <p class="text-[#A7C5B5] text-sm sm:text-base max-w-xl leading-relaxed">
                Selamat datang kembali di panel administrasi. Ringkasan ini menggunakan data yang tersimpan di database aplikasi.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Homestay</span>
                    <div class="p-3 bg-[#EAF2EE] rounded-xl text-[#2B4C3F] group-hover:bg-[#2B4C3F] group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalHomestay }}</div>
                <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                    <span class="text-[#2B4C3F] font-bold">{{ $homestayBaruBulanIni }} unit baru</span> bulan ini
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Souvenir</span>
                    <div class="p-3 bg-[#EAF2EE] rounded-xl text-[#2B4C3F] group-hover:bg-[#2B4C3F] group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalSouvenir }}</div>
                <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                    <span class="text-[#2B4C3F] font-bold">{{ $souvenirTersedia }} tersedia</span> di katalog
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Reservasi</span>
                    <div class="p-3 bg-[#EAF2EE] rounded-xl text-[#2B4C3F] group-hover:bg-[#2B4C3F] group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalReservasi }}</div>
                <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                    <span class="text-[#2B4C3F] font-bold">{{ $reservasiAktif }} reservasi aktif</span> perlu dipantau
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#E6E4DD] shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total User</span>
                    <div class="p-3 bg-[#EAF2EE] rounded-xl text-[#2B4C3F] group-hover:bg-[#2B4C3F] group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-serif font-semibold text-[#2C3E35] mb-1">{{ $totalUser }}</div>
                <p class="text-xs text-[#5C6E65] flex items-center gap-1">
                    <span class="text-[#2B4C3F] font-bold">{{ $userBaruBulanIni }} user baru</span> bulan ini
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Pendapatan Bulan Ini</span>
                <div class="mt-3 text-3xl font-serif font-semibold text-[#2B4C3F]">
                    Rp {{ number_format((float) $pendapatanBulanIni, 0, ',', '.') }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">Dihitung dari pembayaran terverifikasi.</p>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Pembayaran Menunggu</span>
                <div class="mt-3 text-3xl font-serif font-semibold text-[#2B4C3F]">
                    {{ $pembayaranMenunggu }}
                </div>
                <p class="text-xs text-[#5C6E65] mt-2">Bukti pembayaran yang belum diverifikasi admin.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-serif font-semibold text-[#2C3E35]">Pengguna Baru Terdaftar</h3>
                        <p class="text-xs text-[#8A9C91]">Daftar 3 user terakhir dari database</p>
                    </div>
                </div>

                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-xs uppercase tracking-wider">
                                <th class="pb-3">User ID</th>
                                <th class="pb-3">Nama</th>
                                <th class="pb-3">Email</th>
                                <th class="pb-3">No. HP</th>
                                <th class="pb-3">Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                            @forelse ($recentUsers as $user)
                                <tr class="group hover:bg-[#FAF9F6] transition-colors">
                                    <td class="py-3.5 font-mono text-xs font-semibold text-[#2B4C3F]">{{ $user->user_id }}</td>
                                    <td class="py-3.5 font-medium">
                                        {{ $user->nama }}
                                        @if ($user->is(auth()->user()))
                                            <span class="text-[#8A9C91]">(Anda)</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-[#5C6E65]">{{ $user->email }}</td>
                                    <td class="py-3.5 text-[#5C6E65]">{{ $user->no_hp }}</td>
                                    <td class="py-3.5">
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full {{ $user->role === 'admin' ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-sm text-[#8A9C91]">Belum ada user terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="lg:hidden space-y-3">
                    @forelse ($recentUsers as $user)
                        <div class="bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] p-4">
                            <div class="flex items-start justify-between mb-2">
                                <span class="font-mono text-xs font-semibold text-[#2B4C3F]">{{ $user->user_id }}</span>
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full {{ $user->role === 'admin' ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]' }}">
                                    {{ $user->role }}
                                </span>
                            </div>
                            <div class="text-sm font-medium text-[#2C3E35]">
                                {{ $user->nama }}
                                @if ($user->is(auth()->user()))
                                    <span class="text-[#8A9C91]">(Anda)</span>
                                @endif
                            </div>
                            <div class="mt-3 pt-3 border-t border-[#E6E4DD] space-y-1.5">
                                <div class="flex justify-between gap-4 text-xs">
                                    <span class="text-[#8A9C91]">Email</span>
                                    <span class="text-[#5C6E65] truncate">{{ $user->email }}</span>
                                </div>
                                <div class="flex justify-between gap-4 text-xs">
                                    <span class="text-[#8A9C91]">No. HP</span>
                                    <span class="text-[#5C6E65]">{{ $user->no_hp }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] p-4 text-center text-sm text-[#8A9C91]">
                            Belum ada user terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-serif font-semibold text-[#2C3E35] mb-2">Informasi Sistem</h3>
                    <p class="text-xs text-[#5C6E65] mb-6 leading-relaxed">
                        Sistem ini berjalan menggunakan Laravel 13, Blade, Tailwind CSS v4, dan custom authentication dengan middleware role manual.
                    </p>

                    <div class="space-y-4">
                        <div class="p-4 bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] flex items-start gap-3">
                            <div class="p-2 bg-[#2B4C3F]/10 text-[#2B4C3F] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#2C3E35] uppercase">Authentication</h4>
                                <p class="text-xs text-[#8A9C91] mt-0.5">Login, register, logout, profil, dan role admin/user sudah tersedia.</p>
                            </div>
                        </div>

                        <div class="p-4 bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] flex items-start gap-3">
                            <div class="p-2 bg-[#2B4C3F]/10 text-[#2B4C3F] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#2C3E35] uppercase">Primary Key Custom</h4>
                                <p class="text-xs text-[#8A9C91] mt-0.5">User ID otomatis dibuat dengan format USRXXX.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-[#E6E4DD] text-center">
                    <span class="text-xs text-[#8A9C91]">PBL Kelompok - Aura Stay & Style</span>
                </div>
            </div>
        </div>
    </div>
@endsection
