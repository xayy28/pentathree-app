@extends(auth()->user()->role === 'admin' ? 'layouts.app' : 'layouts.user')

@section('title', auth()->user()->role === 'admin' ? 'Kelola Homestay' : 'Menu Homestay')

@section('content')
<div class="space-y-8">
    
    @if(auth()->user()->role === 'admin')
        <!-- ADMIN INTERFACE -->
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                        Kelola Homestay
                    </h1>
                    <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                        Halaman pengelolaan Homestay untuk panel administrasi Natasha Homestay.
                    </p>
                </div>

                <a href="{{ route('admin.homestay.create') }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Homestay
                </a>
            </div>

            @if($homestays->isEmpty())
                <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                    <span class="text-5xl mb-4">🏠</span>
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Homestay</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                        Belum ada data homestay yang terdaftar di database. Silakan klik tombol di bawah untuk menambahkan.
                    </p>
                    <a href="{{ route('admin.homestay.create') }}" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                        Tambah Homestay Pertama
                    </a>
                </div>
            @else
                <!-- Desktop & Tablet: Table -->
                <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 90px;">Foto</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Homestay</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Harga / Malam</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Kapasitas</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Status</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($homestays as $i => $homestay)
                                <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;" 
                                    onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'" 
                                    onmouseout="this.style.background='transparent'">
                                    <!-- Foto -->
                                    <td style="padding: 16px;">
                                        @if($homestay->foto)
                                            <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" 
                                                 style="width: 64px; height: 50px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                        @else
                                            <div style="width: 64px; height: 50px; background: #FAF9F6; border: 1.5px solid #E6E4DD; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🏠</div>
                                        @endif
                                    </td>

                                    <!-- Nama & Detail -->
                                    <td style="padding: 16px; max-width: 240px;">
                                        <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $homestay->nama_homestay }}
                                        </span>
                                        @if($homestay->detail)
                                            <span style="display: block; font-size: 0.72rem; color: #8A9C91; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $homestay->detail }}">
                                                {{ $homestay->detail }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Harga -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 5px 10px; font-size: 0.8rem; font-weight: 700; color: #2B4C3F;">
                                            Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Kapasitas -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem;">
                                            <svg width="14" height="14" fill="none" stroke="#8A9C91" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $homestay->kapasitas }} Orang
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td style="padding: 16px;">
                                        @if($homestay->status === 'Tersedia')
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #EAF2EE; color: #2B4C3F; border: 1px solid #B8DEC8;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #2B4C3F; display: inline-block;"></span>
                                                Tersedia
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #FDF2F2; color: #9B1C1C; border: 1px solid #F5C2C2;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #E65F5F; display: inline-block;"></span>
                                                {{ $homestay->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td style="padding: 12px 16px; text-align: left;">
                                        <div style="display: inline-flex; align-items: center; gap: 4px; background: #F7F6F2; border: 1px solid #E6E4DD; border-radius: 10px; padding: 4px;">
                                            <a href="{{ route('admin.homestay.edit', $homestay->homestay_id) }}" 
                                               title="Edit"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #5C6E65; background: transparent; transition: all 0.15s ease; text-decoration: none;"
                                               onmouseover="this.style.background='white'; this.style.color='#2B4C3F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                               onmouseout="this.style.background='transparent'; this.style.color='#5C6E65'; this.style.boxShadow='none';">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <div style="width: 1px; height: 16px; background: #E6E4DD;"></div>
                                            <form action="{{ route('admin.homestay.destroy', $homestay->homestay_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus homestay ini?')" style="display: inline;">
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
                    @foreach($homestays as $homestay)
                        <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                @if($homestay->foto)
                                    <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-20 h-16 object-cover rounded-lg border border-[#E6E4DD] flex-shrink-0">
                                @else
                                    <div class="w-20 h-16 bg-white border border-[#E6E4DD] rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🏠</div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $homestay->nama_homestay }}</h4>
                                    <p class="text-xs text-[#8A9C91]">{{ $homestay->kapasitas }} Orang</p>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#E6E4DD] flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-[#8A9C91] block">Mulai dari</span>
                                    <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    @if($homestay->status === 'Tersedia')
                                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">Tersedia</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C]">{{ $homestay->status }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2 border-t border-[#E6E4DD]/50">
                                <a href="{{ route('admin.homestay.edit', $homestay->homestay_id) }}" class="px-3 py-1.5 text-xs font-semibold border border-[#E6E4DD] text-[#5C6E65] hover:bg-[#FAF9F6] rounded-lg transition-colors flex items-center gap-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.homestay.destroy', $homestay->homestay_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus homestay ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-[#E65F5F]/10 text-[#FF9E9E] hover:bg-[#E65F5F] hover:text-white rounded-lg transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
    @else
        <!-- USER INTERFACE (Katalog Homestay Sesuai Mockup) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-[#F8F7F4]">
            
            <!-- Section Title & Search Needs -->
            <div class="text-center space-y-8">
                <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
                    Search based on needs
                </h2>

                <!-- Form Filter Tampilan Statis -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-6 sm:gap-10">
                    <!-- Check-in & Check-out -->
                    <div class="w-full max-w-xs space-y-2">
                        <span class="block text-center sm:text-left text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">
                            Tanggal Check-in & Check-out
                        </span>
                        <div class="relative flex items-center justify-between bg-[#1E362C] hover:bg-[#254236] text-white rounded-xl px-5 py-3.5 cursor-pointer transition-all shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-white/70">Pilih Tanggal</span>
                            </div>
                            <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Jumlah Tamu -->
                    <div class="w-full max-w-xs space-y-2">
                        <span class="block text-center sm:text-left text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]">
                            Jumlah Tamu
                        </span>
                        <div class="relative flex items-center justify-between bg-[#1E362C] hover:bg-[#254236] text-white rounded-xl px-5 py-3.5 transition-all shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span id="guest-count-text" class="text-sm font-medium text-white/70">Pilih Jumlah Tamu</span>
                            </div>
                            <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <!-- Hidden Select Element overlaying the visual box -->
                            <select id="guest-count-select" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer bg-white text-[#2C3E35]">
                                <option value="" disabled selected hidden class="bg-white text-[#2C3E35]">Pilih Jumlah Tamu</option>
                                <option value="1" class="bg-white text-[#2C3E35]">1 Orang</option>
                                <option value="2" class="bg-white text-[#2C3E35]">2 Orang</option>
                                <option value="3" class="bg-white text-[#2C3E35]">3 Orang</option>
                                <option value="4" class="bg-white text-[#2C3E35]">4 Orang</option>
                                <option value="5" class="bg-white text-[#2C3E35]">5+ Orang</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Catalog Area (Sidebar + Rooms Grid) -->
            <div class="flex flex-col md:flex-row gap-10 items-start">
                
                <!-- Left Sidebar: Filter Stays -->
                <div class="w-full md:w-64 flex-shrink-0 space-y-6">
                    <h3 class="font-serif text-2xl text-[#2B4C3F] font-semibold tracking-wide border-b border-[#E6E4DD] pb-3">
                        Filter Stays
                    </h3>
                    <div class="flex flex-col gap-3" id="floor-filters">
                        <!-- All Rooms (Active by default) -->
                        <button data-filter="all" class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-semibold shadow-sm bg-[#EAF2EE] border-[#A7C5B5] text-[#2B4C3F] active-filter-btn">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span>All Rooms</span>
                        </button>
                        
                        <!-- Lantai 1 -->
                        <button data-filter="1" class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Lantai 1</span>
                        </button>

                        <!-- Lantai 2 -->
                        <button data-filter="2" class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border transition-all text-left font-medium bg-white border-[#E6E4DD] text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] hover:shadow-sm">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <span>Lantai 2</span>
                        </button>
                    </div>
                </div>

                <!-- Right Content: Room Grid -->
                <div class="flex-grow w-full space-y-6">
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-[#8A9C91]" id="room-count-label">
                        Menampilkan {{ $homestays->count() }} Kamar yang Tersedia
                    </span>

                    @if($homestays->isEmpty())
                        <div class="bg-white rounded-3xl border border-[#E6E4DD] p-12 text-center flex flex-col items-center justify-center shadow-sm">
                            <span class="text-5xl mb-4">🏠</span>
                            <h3 class="text-lg font-serif font-semibold text-[#2C3E35] mb-1">Homestay Belum Tersedia</h3>
                            <p class="text-xs text-[#8A9C91] max-w-sm">
                                Kami sedang menyiapkan beberapa pilihan homestay terbaik untuk Anda. Silakan kembali beberapa saat lagi!
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8" id="homestay-grid">
                            @foreach($homestays as $homestay)
                                @php
                                    // =========================================================================
                                    // TODO: PEMETAAN LANTAI STATIS (Sifatnya Sementara)
                                    // Jika suatu saat Anda menambahkan kolom 'lantai' di database (tabel homestays),
                                    // Anda dapat mengganti seluruh blok logika di bawah ini menjadi:
                                    // $floor = $homestay->lantai;
                                    // =========================================================================
                                    $floor = 1;
                                    $lowercaseName = strtolower($homestay->nama_homestay);
                                    $lowercaseDetail = strtolower($homestay->detail);
                                    if (
                                        str_contains($lowercaseName, 'lantai 2') || 
                                        str_contains($lowercaseDetail, 'lantai 2') ||
                                        str_contains($lowercaseName, 'kamar 3') || 
                                        str_contains($lowercaseName, 'kamar 4') ||
                                        str_contains($lowercaseName, 'rustic') ||
                                        str_contains($lowercaseName, 'lodge')
                                    ) {
                                        $floor = 2;
                                    }
                                @endphp
                                <div class="bg-white rounded-3xl overflow-hidden border border-[#E6E4DD]/60 shadow-sm hover:shadow-md hover:border-[#A7C5B5]/30 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between homestay-card" data-floor="{{ $floor }}" data-capacity="{{ $homestay->kapasitas }}">
                                    <div>
                                        <!-- Image Container -->
                                        <div class="h-60 overflow-hidden relative bg-[#EAF2EE]/50">
                                            @if($homestay->foto)
                                                <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @else
                                                <!-- Fallback default Unsplash Room image if no image uploaded -->
                                                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80" alt="{{ $homestay->nama_homestay }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @endif
                                            @if($homestay->status === 'Tersedia')
                                                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm border border-[#A7C5B5]/20 text-[9px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-white px-3 py-1.5 rounded-full shadow-sm">
                                                    {{ $homestay->status }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Room Info -->
                                        <div class="p-6 space-y-3">
                                            <h4 class="font-serif font-semibold text-xl text-[#2C3E35] pb-2.5 border-b border-[#F0EDE6]">
                                                {{ $homestay->nama_homestay }}
                                            </h4>
                                            <p class="text-xs text-[#8A9C91] leading-relaxed">
                                                Kapasitas: {{ $homestay->kapasitas }} Orang &bull; Lantai {{ $floor }}
                                            </p>
                                            @if($homestay->detail)
                                                <p class="text-xs text-[#5C6E65] line-clamp-2 leading-relaxed" title="{{ $homestay->detail }}">
                                                    {{ $homestay->detail }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
 
                                    <!-- Price & Action -->
                                    <div class="p-6 pt-0">
                                        <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                                            <div>
                                                <span class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Harga / malam</span>
                                                <span class="text-base font-semibold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                                            </div>
                                            @if($homestay->status === 'Tersedia')
                                                <a href="{{ route('user.reservasi', ['homestay_id' => $homestay->homestay_id]) }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                                                    Pesan
                                                </a>
                                            @else
                                                <button disabled class="px-5 py-2.5 bg-[#FAF9F6] border border-[#E6E4DD] text-[#8A9C91] text-xs font-semibold rounded-xl cursor-not-allowed">
                                                    Penuh
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Javascript untuk Filtering Client-side yang Halus -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const filters = document.querySelectorAll('#floor-filters button');
                const cards = document.querySelectorAll('.homestay-card');
                const label = document.getElementById('room-count-label');

                const guestSelect = document.getElementById('guest-count-select');
                const guestText = document.getElementById('guest-count-text');

                let activeFloor = 'all';
                let activeGuests = 0;

                function applyFilters() {
                    let visibleCount = 0;
                    cards.forEach(card => {
                        const cardFloor = card.getAttribute('data-floor');
                        const cardCapacity = parseInt(card.getAttribute('data-capacity') || '0', 10);

                        const matchesFloor = (activeFloor === 'all' || cardFloor === activeFloor);
                        const matchesGuests = (cardCapacity >= activeGuests);

                        if (matchesFloor && matchesGuests) {
                            card.style.display = 'flex';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (label) {
                        label.textContent = `Menampilkan ${visibleCount} Kamar yang Tersedia`;
                    }
                }

                // Guest Count Selector listener
                if (guestSelect && guestText) {
                    guestSelect.addEventListener('change', function () {
                        guestText.textContent = this.options[this.selectedIndex].text;
                        guestText.classList.remove('text-white/70');
                        guestText.classList.add('text-white');

                        activeGuests = parseInt(this.value || '0', 10);
                        applyFilters();
                    });
                }

                filters.forEach(btn => {
                    btn.addEventListener('click', function () {
                        // Reset filter buttons state
                        filters.forEach(f => {
                            f.classList.remove('bg-[#EAF2EE]', 'border-[#A7C5B5]', 'text-[#2B4C3F]', 'font-semibold', 'shadow-sm', 'active-filter-btn');
                            f.classList.add('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]', 'font-medium');
                        });

                        // Set active state to clicked button
                        this.classList.remove('bg-white', 'border-[#E6E4DD]', 'text-[#5C6E65]', 'font-medium');
                        this.classList.add('bg-[#EAF2EE]', 'border-[#A7C5B5]', 'text-[#2B4C3F]', 'font-semibold', 'shadow-sm', 'active-filter-btn');

                        activeFloor = this.getAttribute('data-filter');
                        applyFilters();
                    });
                });
            });
        </script>
    @endif

</div>
@endsection
