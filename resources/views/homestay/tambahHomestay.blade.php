@extends('layouts.app')

@section('title', 'Tambah Homestay')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-1">
                Tambah Homestay Baru
            </h1>
            <p class="text-xs sm:text-sm text-[#5C6E65]">
                Lengkapi formulir di bawah ini untuk mendaftarkan homestay baru ke dalam sistem.
            </p>
        </div>
        <a href="{{ route('admin.homestay') }}" class="px-4 py-2 border border-[#E6E4DD] hover:bg-[#FAF9F6] text-[#2C3E35] text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.homestay.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Homestay -->
                <div class="space-y-2">
                    <label for="nama_homestay" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Nama Homestay</label>
                    <input type="text" 
                           id="nama_homestay" 
                           name="nama_homestay" 
                           value="{{ old('nama_homestay') }}" 
                           placeholder="Masukkan nama homestay"
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] placeholder-[#8A9C91] text-sm outline-none transition-all @error('nama_homestay') border-red-500 @enderror">
                    @error('nama_homestay')
                        <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Per Malam -->
                <div class="space-y-2">
                    <label for="harga_permalam" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Harga Per Malam (Rp)</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-sm font-semibold text-[#8A9C91]">Rp</span>
                        <input type="number" 
                               id="harga_permalam" 
                               name="harga_permalam" 
                               value="{{ old('harga_permalam') }}" 
                               placeholder="Contoh: 750000"
                               class="w-full pl-11 pr-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] placeholder-[#8A9C91] text-sm outline-none transition-all @error('harga_permalam') border-red-500 @enderror">
                    </div>
                    @error('harga_permalam')
                        <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas -->
                <div class="space-y-2">
                    <label for="kapasitas" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Kapasitas (Orang)</label>
                    <input type="number" 
                           id="kapasitas" 
                           name="kapasitas" 
                           value="{{ old('kapasitas') }}" 
                           placeholder="Jumlah kapasitas tamu"
                           class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] placeholder-[#8A9C91] text-sm outline-none transition-all @error('kapasitas') border-red-500 @enderror">
                    @error('kapasitas')
                        <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Status</label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] text-sm outline-none transition-all @error('status') border-red-500 @enderror">
                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Detail / Deskripsi -->
            <div class="space-y-2">
                <label for="detail" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Detail / Deskripsi</label>
                <textarea id="detail" 
                          name="detail" 
                          rows="4" 
                          placeholder="Jelaskan fasilitas, kelebihan, dan detail homestay di sini..."
                          class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] placeholder-[#8A9C91] text-sm outline-none transition-all @error('detail') border-red-500 @enderror">{{ old('detail') }}</textarea>
                @error('detail')
                    <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Foto -->
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-[#8A9C91] block">Foto Homestay</label>
                <div class="flex items-center gap-4">
                    <div class="relative flex-grow">
                        <input type="file" 
                               id="foto" 
                               name="foto" 
                               accept="image/*"
                               onchange="previewImage(event)"
                               class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] rounded-xl text-[#2C3E35] text-sm outline-none transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EAF2EE] file:text-[#2B4C3F] hover:file:bg-[#2B4C3F] hover:file:text-white file:transition-colors file:cursor-pointer @error('foto') border-red-500 @enderror">
                    </div>
                </div>
                <div id="image-preview-container" class="hidden mt-4">
                    <p class="text-xs text-[#8A9C91] mb-2">Pratinjau Foto:</p>
                    <img id="image-preview" src="#" alt="Pratinjau" class="w-full max-w-md h-64 object-cover rounded-2xl border border-[#E6E4DD]">
                </div>
                @error('foto')
                    <p class="text-xs text-[#E65F5F] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-[#F2F0EA] flex justify-end gap-3">
                <a href="{{ route('admin.homestay') }}" class="px-5 py-2.5 bg-[#FAF9F6] border border-[#D5D3C7] hover:bg-[#F2F0EA] text-[#2C3E35] text-sm font-semibold rounded-xl transition-all">
                    Batalkan
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                    Simpan Homestay
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const container = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            container.classList.add('hidden');
        }
    }
</script>
@endsection
