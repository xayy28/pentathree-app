@extends('layouts.app')

@section('title', 'Kelola Fasilitas')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                    Kelola Fasilitas
                </h1>
                <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                    Halaman pengelolaan fasilitas untuk panel administrasi Natasha Homestay.
                </p>
            </div>

            <x-ui-button href="{{ route('admin.fasilitas.create') }}" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Fasilitas
            </x-ui-button>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 20px; padding: 12px 16px; background: #EAF2EE; border: 1px solid #B8DEC8; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                <svg width="16" height="16" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size: 0.82rem; font-weight: 600; color: #2B4C3F;">{{ session('success') }}</span>
            </div>
        @endif

        @if($fasilitas->isEmpty())
            <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                <span class="text-5xl mb-4">⭐</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Fasilitas</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data fasilitas yang terdaftar di database. Silakan klik tombol di bawah untuk menambahkan.
                </p>
                <x-ui-button href="{{ route('admin.fasilitas.create') }}" variant="primary">
                    Tambah Fasilitas Pertama
                </x-ui-button>
            </div>
        @else
            <!-- Desktop & Tablet: Table -->
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 60px;">#</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Fasilitas</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 120px;">Ikon</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fasilitas as $f)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;"
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'"
                                onmouseout="this.style.background='transparent'">

                                <td style="padding: 16px; color: #8A9C91; font-weight: 600; text-align: center;">
                                    {{ $loop->iteration }}
                                </td>

                                <td style="padding: 16px;">
                                    <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35;">
                                        {{ $f->nama_fasilitas }}
                                    </span>
                                </td>

                                <td style="padding: 16px; color: #5C6E65;">
                                    @if($f->ikon)
                                        <code style="background: #FAF9F6; border: 1px solid #E6E4DD; padding: 3px 8px; border-radius: 6px; font-size: 0.75rem;">{{ $f->ikon }}</code>
                                    @else
                                        <span style="color: #8A9C91;">-</span>
                                    @endif
                                </td>

                                <td style="padding: 12px 16px; text-align: left;">
                                    <div class="inline-flex items-center gap-2">
                                        <x-ui-button href="{{ route('admin.fasilitas.edit', $f->fasilitas_id) }}" variant="secondary" size="sm">
                                            Edit
                                        </x-ui-button>
                                        <form action="{{ route('admin.fasilitas.destroy', $f->fasilitas_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui-button type="submit" variant="danger" size="sm">
                                                Hapus
                                            </x-ui-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile: Card List -->
            <div class="md:hidden space-y-4">
                @foreach($fasilitas as $f)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35]">{{ $f->nama_fasilitas }}</h4>
                                @if($f->ikon)
                                    <p class="text-xs text-[#8A9C91] mt-1">Ikon: <code>{{ $f->ikon }}</code></p>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-3 border-t border-[#E6E4DD]/50">
                            <x-ui-button href="{{ route('admin.fasilitas.edit', $f->fasilitas_id) }}" variant="secondary" size="sm">
                                Edit
                            </x-ui-button>
                            <form action="{{ route('admin.fasilitas.destroy', $f->fasilitas_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-ui-button type="submit" variant="danger" size="sm">
                                    Hapus
                                </x-ui-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection