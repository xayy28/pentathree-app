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
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 16px; font-size: 0.875rem; font-weight: 600; color: #8A9C91; pointer-events: none; z-index: 10; line-height: 1;">Rp</span>
                        <input type="number" 
                               id="harga_permalam" 
                               name="harga_permalam" 
                               value="{{ old('harga_permalam') }}" 
                               placeholder="750000"
                               style="padding-left: 2.75rem;"
                               class="w-full pr-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] placeholder-[#8A9C91] text-sm outline-none transition-all @error('harga_permalam') border-red-500 @enderror">
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

                <!-- Kategori Homestay -->
                <div class="space-y-2">
                    <label for="kategori_id" class="text-xs font-bold uppercase tracking-wider text-[#8A9C91]">Kategori Homestay</label>
                    <select id="kategori_id" 
                            name="kategori_id" 
                            class="w-full px-4 py-3 bg-[#FAF9F6] border border-[#E6E4DD] focus:border-[#2B4C3F] focus:ring-1 focus:ring-[#2B4C3F] rounded-xl text-[#2C3E35] text-sm outline-none transition-all @error('kategori_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->kategori_id }}" {{ old('kategori_id') == $category->kategori_id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
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
                
                <!-- Custom Upload Zone -->
                <label for="foto" 
                       id="upload-zone"
                       style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; padding: 28px 20px; background: #FAF9F6; border: 2px dashed #D5D3C7; border-radius: 14px; cursor: pointer; transition: all 0.2s ease;"
                       onmouseover="this.style.borderColor='#2B4C3F'; this.style.background='#EEF7F2';"
                       onmouseout="this.style.borderColor='#D5D3C7'; this.style.background='#FAF9F6';">
                    <div style="width: 44px; height: 44px; background: #EAF2EE; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div style="text-align: center;">
                        <span style="display: block; font-size: 0.82rem; font-weight: 600; color: #2C3E35;">Klik untuk pilih foto</span>
                        <span style="display: block; font-size: 0.7rem; color: #8A9C91; margin-top: 3px;">PNG, JPG, JPEG hingga 2MB</span>
                    </div>
                    <input type="file" 
                           id="foto" 
                           name="foto" 
                           accept="image/*"
                           onchange="previewImage(event)"
                           style="display: none;">
                </label>

                <!-- File Name Preview -->
                <div id="file-name-display" style="display: none; align-items: center; gap: 8px; padding: 10px 14px; background: #EAF2EE; border-radius: 10px; border: 1px solid #B8DEC8;">
                    <svg width="14" height="14" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="file-name-text" style="font-size: 0.75rem; font-weight: 600; color: #2B4C3F;"></span>
                </div>

                <div id="image-preview-container" style="display: none; margin-top: 12px;">
                    <p style="font-size: 0.7rem; color: #8A9C91; margin-bottom: 8px;">Pratinjau Foto:</p>
                    <img id="image-preview" src="#" alt="Pratinjau" style="width: 100%; max-width: 320px; height: 180px; object-fit: cover; border-radius: 14px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
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
        const fileNameDisplay = document.getElementById('file-name-display');
        const fileNameText = document.getElementById('file-name-text');
        const uploadZone = document.getElementById('upload-zone');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
                if (fileNameDisplay) {
                    fileNameText.textContent = file.name;
                    fileNameDisplay.style.display = 'flex';
                }
                if (uploadZone) {
                    uploadZone.style.borderColor = '#2B4C3F';
                    uploadZone.style.background = '#EEF7F2';
                }
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            container.style.display = 'none';
            if (fileNameDisplay) fileNameDisplay.style.display = 'none';
            if (uploadZone) {
                uploadZone.style.borderColor = '#D5D3C7';
                uploadZone.style.background = '#FAF9F6';
            }
        }
    }
</script>
@endsection
