@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                    Kelola User
                </h1>
                <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                    Pantau data pengguna dan admin yang terdaftar di sistem.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
            <div class="rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Total Admin</p>
                <p class="text-2xl font-bold text-[#2C3E35] mt-1">{{ number_format($totalAdmin, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#A7C5B5] bg-[#EAF2EE] px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#5C6E65]">Total Pelanggan</p>
                <p class="text-2xl font-bold text-[#2B4C3F] mt-1">{{ number_format($totalUser, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#E6E4DD] bg-white px-4 py-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Email Terverifikasi</p>
                <p class="text-2xl font-bold text-[#2C3E35] mt-1">{{ number_format($totalVerifikasi, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($users->isEmpty())
            <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                <span class="text-5xl mb-4">User</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada User</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data pengguna yang terdaftar saat ini.
                </p>
            </div>
        @else
            {{-- Desktop & Tablet: Table --}}
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 60px;">#</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">ID User</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Email</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Role</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">No. HP</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;"
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding: 16px; color: #8A9C91; font-weight: 600; text-align: center;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="padding: 16px;">
                                    <span style="font-family: monospace; font-weight: 700; font-size: 0.8rem; color: #5C6E65;">
                                        {{ $user->user_id }}
                                    </span>
                                </td>
                                <td style="padding: 16px; max-width: 200px;">
                                    <span style="display: block; font-weight: 600; font-size: 0.9rem; color: #2C3E35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $user->nama }}
                                    </span>
                                </td>
                                <td style="padding: 16px;">
                                    <span style="font-size: 0.82rem; color: #5C6E65;">
                                        {{ $user->email }}
                                    </span>
                                </td>
                                <td style="padding: 16px;">
                                    @if($user->role === 'admin')
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; color: #2B4C3F;">
                                            Admin
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #E8F0FE; border: 1px solid #C4D4F0; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; color: #1A3C6E;">
                                            Pelanggan
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 16px;">
                                    <span style="font-size: 0.82rem; color: #5C6E65;">
                                        {{ $user->no_hp ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding: 16px;">
                                    @if($user->email_verified_at)
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; color: #2B4C3F;">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #FDF2F2; border: 1px solid #F5C2C2; border-radius: 8px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; color: #9B1C1C;">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Belum
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile: Card List --}}
            <div class="md:hidden space-y-4">
                @foreach($users as $user)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $user->nama }}</h4>
                                <p class="text-xs text-[#8A9C91]">{{ $user->user_id }}</p>
                            </div>
                            @if($user->role === 'admin')
                                <span style="background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 4px 10px; font-size: 0.7rem; font-weight: 700; color: #2B4C3F; white-space: nowrap;">
                                    Admin
                                </span>
                            @else
                                <span style="background: #E8F0FE; border: 1px solid #C4D4F0; border-radius: 8px; padding: 4px 10px; font-size: 0.7rem; font-weight: 700; color: #1A3C6E; white-space: nowrap;">
                                    Pelanggan
                                </span>
                            @endif
                        </div>
                        <div class="pt-3 border-t border-[#E6E4DD] grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">Email</span>
                                <span class="font-medium text-[#2C3E35] truncate block">{{ $user->email }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-[#8A9C91] block">No. HP</span>
                                <span class="font-medium text-[#2C3E35]">{{ $user->no_hp ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            @if($user->email_verified_at)
                                <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 4px 10px; font-size: 0.7rem; font-weight: 700; color: #2B4C3F;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Email Terverifikasi
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 4px; background: #FDF2F2; border: 1px solid #F5C2C2; border-radius: 8px; padding: 4px 10px; font-size: 0.7rem; font-weight: 700; color: #9B1C1C;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Email Belum Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
