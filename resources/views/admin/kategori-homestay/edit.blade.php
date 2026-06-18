@extends('layouts.app')

@section('title', 'Edit Kategori Homestay')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-4 mb-8 border-b border-[#F2F0EA] pb-6">
            <a href="{{ route('admin.kategori-homestay') }}" class="p-2 text-[#5C6E65] hover:bg-[#FAF9F6] hover:text-[#2C3E35] rounded-xl border border-[#E6E4DD] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-serif font-semibold text-[#2C3E35] mb-1">
                    Edit Kategori
                </h1>
                <p class="text-xs text-[#8A9C91]">
                    Perbarui rincian kategori homestay di Natasha Homestay.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.kategori-homestay.update', $category->kategori_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Kategori -->
            <div class="space-y-2">
                <label for="nama_kategori" class="text-xs font-bold uppercase tracking-wider text-[#5C6E65] block">
                    Nama Kategori <span class="text-[#E65F5F]">*</span>
                </label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" required placeholder="Contoh: Suites, Deluxe, Standard" class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none focus:ring-4 focus:ring-[#EAF2EE] transition-all @error('nama_kategori') border-[#E65F5F] @enderror">
                @error('nama_kategori')
                    <span class="text-xs text-[#E65F5F] font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <label for="deskripsi" class="text-xs font-bold uppercase tracking-wider text-[#5C6E65] block">
                    Deskripsi
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Penjelasan singkat mengenai tipe kamar ini..." class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none focus:ring-4 focus:ring-[#EAF2EE] transition-all @error('deskripsi') border-[#E65F5F] @enderror">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-xs text-[#E65F5F] font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#F2F0EA]">
                <a href="{{ route('admin.kategori-homestay') }}" class="px-5 py-2.5 border border-[#E6E4DD] hover:bg-[#FAF9F6] text-[#5C6E65] text-sm font-semibold rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
