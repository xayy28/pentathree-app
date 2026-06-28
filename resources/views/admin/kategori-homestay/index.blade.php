@extends('layouts.app')

@section('title', 'Kelola Kategori Homestay')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                    Kelola Kategori Homestay
                </h1>
                <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                    Halaman pengelolaan Kategori Homestay untuk panel administrasi Natasha Homestay.
                </p>
            </div>

            <a href="{{ route('admin.kategori-homestay.create') }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </a>
        </div>

        @if($categories->isEmpty())
            <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                <span class="text-5xl mb-4">🏷️</span>
                <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Kategori</h3>
                <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                    Belum ada data kategori homestay yang terdaftar di database. Silakan klik tombol di bawah untuk menambahkan.
                </p>
                <a href="{{ route('admin.kategori-homestay.create') }}" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                    Tambah Kategori Pertama
                </a>
            </div>
        @else
            <!-- Desktop & Tablet: Table -->
            <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 80px;">ID</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Kategori</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Deskripsi</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 150px;">Jumlah Kamar</th>
                            <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;" 
                                onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'" 
                                onmouseout="this.style.background='transparent'">
                                
                                <td style="padding: 16px; color: #8A9C91; font-weight: 600;">
                                    #{{ $category->kategori_id }}
                                </td>

                                <td style="padding: 16px;">
                                    <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35;">
                                        {{ $category->nama_kategori }}
                                    </span>
                                </td>

                                <td style="padding: 16px; color: #5C6E65; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $category->deskripsi }}">
                                    {{ $category->deskripsi ?? '-' }}
                                </td>

                                <td style="padding: 16px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #2B4C3F; font-weight: 600; font-size: 0.85rem; background: #EAF2EE; border: 1px solid #B8DEC8; padding: 4px 10px; border-radius: 8px;">
                                        {{ $category->homestays_count }} Kamar
                                    </span>
                                </td>

                                <td style="padding: 12px 16px; text-align: left;">
                                    <div style="display: inline-flex; align-items: center; gap: 4px; background: #F7F6F2; border: 1px solid #E6E4DD; border-radius: 10px; padding: 4px;">
                                        <a href="{{ route('admin.kategori-homestay.edit', $category->kategori_id) }}" 
                                           title="Edit"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #5C6E65; background: transparent; transition: all 0.15s ease; text-decoration: none;"
                                           onmouseover="this.style.background='white'; this.style.color='#2B4C3F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                           onmouseout="this.style.background='transparent'; this.style.color='#5C6E65'; this.style.boxShadow='none';">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <div style="width: 1px; height: 16px; background: #E6E4DD;"></div>
                                        <form action="{{ route('admin.kategori-homestay.destroy', $category->kategori_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #8A9C91; background: transparent; cursor: pointer; transition: all 0.15s ease;"
                                                    onmouseover="this.style.background='#FDF2F2'; this.style.color='#E65F5F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                                    onmouseout="this.style.background='transparent'; this.style.color='#8A9C91'; this.style.boxShadow='none';">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
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
                @foreach($categories as $category)
                    <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-serif font-semibold text-base text-[#2C3E35]">{{ $category->nama_kategori }}</h4>
                                <p class="text-xs text-[#8A9C91] mt-1">{{ $category->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-[#EAF2EE] text-[#2B4C3F]">
                                {{ $category->homestays_count }} Kamar
                            </span>
                        </div>
                        <div class="flex justify-end gap-2 pt-3 border-t border-[#E6E4DD]/50">
                            <a href="{{ route('admin.kategori-homestay.edit', $category->kategori_id) }}" class="px-3 py-1.5 text-xs font-semibold border border-[#E6E4DD] text-[#5C6E65] hover:bg-[#FAF9F6] rounded-lg transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.kategori-homestay.destroy', $category->kategori_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-[#E65F5F]/10 text-[#FF9E9E] hover:bg-[#E65F5F] hover:text-white rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
