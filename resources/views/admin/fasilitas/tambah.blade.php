@extends('layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-4 mb-8 border-b border-[#F2F0EA] pb-6">
            @include('components.back-link', ['href' => route('admin.fasilitas'), 'label' => 'Kembali'])
            <div>
                <h1 class="text-xl sm:text-2xl font-serif font-semibold text-[#2C3E35] mb-1">
                    Tambah Fasilitas Baru
                </h1>
                <p class="text-xs text-[#8A9C91]">
                    Tambahkan fasilitas baru yang tersedia di homestay Natasha Homestay.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.fasilitas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Fasilitas -->
            <div class="space-y-2">
                <label for="nama_fasilitas" class="text-xs font-bold uppercase tracking-wider text-[#5C6E65] block">
                    Nama Fasilitas <span class="text-[#E65F5F]">*</span>
                </label>
                <input type="text" name="nama_fasilitas" id="nama_fasilitas" value="{{ old('nama_fasilitas') }}" required placeholder="Contoh: WiFi Gratis, AC, Kolam Renang" class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none focus:ring-4 focus:ring-[#EAF2EE] transition-all @error('nama_fasilitas') border-[#E65F5F] @enderror">
                @error('nama_fasilitas')
                    <span class="text-xs text-[#E65F5F] font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Ikon -->
            <div class="space-y-2">
                <label for="ikon" class="text-xs font-bold uppercase tracking-wider text-[#5C6E65] block">
                    Ikon (key)
                </label>
                <input type="text" name="ikon" id="ikon" value="{{ old('ikon') }}" placeholder="wifi, ac, pool, tv, kitchen, dll." class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none focus:ring-4 focus:ring-[#EAF2EE] transition-all @error('ikon') border-[#E65F5F] @enderror">
                <p class="text-xs text-[#8A9C91]">Key untuk mapping ikon SVG. Contoh: wifi, ac, pool, parking, kitchen, shower, tv, breakfast.</p>
                @error('ikon')
                    <span class="text-xs text-[#E65F5F] font-medium block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#F2F0EA]">
                <x-ui-button href="{{ route('admin.fasilitas') }}" variant="muted">
                    Batal
                </x-ui-button>
                <x-ui-button type="submit" variant="primary">
                    Simpan Fasilitas
                </x-ui-button>
            </div>
        </form>
    </div>
</div>
@endsection