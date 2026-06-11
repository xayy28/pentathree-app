@extends('layouts.app')

@section('title', auth()->user()->role === 'admin' ? 'Kelola Souvenir' : 'Menu Souvenir')

@section('content')
<div class="space-y-8">
    
    @if(auth()->user()->role === 'admin')
        <!-- ADMIN INTERFACE -->
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-[#2C3E35] mb-2">
                        Kelola Souvenir
                    </h1>
                    <p class="text-xs sm:text-sm text-[#5C6E65] leading-relaxed">
                        Halaman pengelolaan Souvenir untuk panel administrasi Natasha Homestay.
                    </p>
                </div>

                <a href="{{ route('admin.souvenir.create') }}" class="px-5 py-2.5 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Souvenir
                </a>
            </div>

            @if($souvenirs->isEmpty())
                <div class="p-8 sm:p-12 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-2xl flex flex-col items-center justify-center text-center">
                    <span class="text-5xl mb-4">🏺</span>
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Belum Ada Souvenir</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm mb-6">
                        Belum ada data souvenir yang terdaftar di database. Silakan klik tombol di bawah untuk menambahkan.
                    </p>
                    <a href="{{ route('admin.souvenir.create') }}" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                        Tambah Souvenir Pertama
                    </a>
                </div>
            @else
                <!-- Desktop & Tablet: Table -->
                <div class="hidden md:block overflow-x-auto" style="border-radius: 16px; border: 1px solid #E6E4DD; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #F7F6F2 0%, #EEF0EB 100%); border-bottom: 2px solid #E6E4DD;">
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91; width: 90px;">Foto</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Nama Souvenir</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Harga</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Stok</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Terjual</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Diperbarui Oleh</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Status</th>
                                <th style="padding: 14px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8A9C91;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($souvenirs as $souvenir)
                                <tr style="border-bottom: 1px solid #F2F0EA; transition: background 0.15s ease;" 
                                    onmouseover="this.style.background='linear-gradient(90deg, #FAF9F6 0%, #F5F4F0 100%)'" 
                                    onmouseout="this.style.background='transparent'">
                                    <!-- Foto -->
                                    <td style="padding: 16px;">
                                        @if($souvenir->foto)
                                            <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" 
                                                 style="width: 64px; height: 50px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E6E4DD; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                                        @else
                                            <div style="width: 64px; height: 50px; background: #FAF9F6; border: 1.5px solid #E6E4DD; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🏺</div>
                                        @endif
                                    </td>

                                    <!-- Nama & Detail -->
                                    <td style="padding: 16px; max-width: 240px;">
                                        <span style="display: block; font-family: Georgia, serif; font-weight: 600; font-size: 0.95rem; color: #2C3E35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $souvenir->nama_souvenir }}
                                        </span>
                                        @if($souvenir->detail)
                                            <span style="display: block; font-size: 0.72rem; color: #8A9C91; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $souvenir->detail }}">
                                                {{ $souvenir->detail }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Harga -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #EEF7F2; border: 1px solid #C8E6D4; border-radius: 8px; padding: 5px 10px; font-size: 0.8rem; font-weight: 700; color: #2B4C3F;">
                                            Rp {{ number_format($souvenir->harga, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Stok -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem;">
                                            {{ $souvenir->stok }} pcs
                                        </span>
                                    </td>

                                    <!-- Terjual (read-only, dikelola sistem) -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; background: #FFF8EC; border: 1px solid #FDDEA0; border-radius: 8px; font-size: 0.78rem; font-weight: 600; color: #92620A;">
                                            🔥 {{ $souvenir->jumlah_terjual }}
                                        </span>
                                    </td>

                                    <!-- Diperbarui Oleh -->
                                    <td style="padding: 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 5px; color: #5C6E65; font-size: 0.82rem;">
                                            {{ $souvenir->updater->nama ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td style="padding: 16px;">
                                        @if($souvenir->status === 'Tersedia')
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #EAF2EE; color: #2B4C3F; border: 1px solid #B8DEC8;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #2B4C3F; display: inline-block;"></span>
                                                Tersedia
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-radius: 999px; background: #FDF2F2; color: #9B1C1C; border: 1px solid #F5C2C2;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #E65F5F; display: inline-block;"></span>
                                                Habis
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td style="padding: 12px 16px; text-align: left;">
                                        <div style="display: inline-flex; align-items: center; gap: 4px; background: #F7F6F2; border: 1px solid #E6E4DD; border-radius: 10px; padding: 4px;">
                                            <a href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}" 
                                               title="Edit"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 7px; border: none; color: #5C6E65; background: transparent; transition: all 0.15s ease; text-decoration: none;"
                                               onmouseover="this.style.background='white'; this.style.color='#2B4C3F'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.08)';"
                                               onmouseout="this.style.background='transparent'; this.style.color='#5C6E65'; this.style.boxShadow='none';">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <div style="width: 1px; height: 16px; background: #E6E4DD;"></div>
                                            <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" style="display: inline;">
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
                    @foreach($souvenirs as $souvenir)
                        <div class="bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4 flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                @if($souvenir->foto)
                                    <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-20 h-16 object-cover rounded-lg border border-[#E6E4DD] flex-shrink-0">
                                @else
                                    <div class="w-20 h-16 bg-white border border-[#E6E4DD] rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🏺</div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="font-serif font-semibold text-base text-[#2C3E35] truncate">{{ $souvenir->nama_souvenir }}</h4>
                                    <p class="text-xs text-[#8A9C91]">Stok: {{ $souvenir->stok }} pcs &bull; 🔥 Terjual: {{ $souvenir->jumlah_terjual }} pcs</p>
                                    <p class="text-[10px] text-[#8A9C91] mt-0.5">Editor: {{ $souvenir->updater->nama ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#E6E4DD] flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-[#8A9C91] block">Harga</span>
                                    <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    @if($souvenir->status === 'Tersedia')
                                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">Tersedia</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C]">Habis</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2 border-t border-[#E6E4DD]/50">
                                <a href="{{ route('admin.souvenir.edit', $souvenir->souvenir_id) }}" class="px-3 py-1.5 text-xs font-semibold border border-[#E6E4DD] text-[#5C6E65] hover:bg-[#FAF9F6] rounded-lg transition-colors flex items-center gap-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.souvenir.destroy', $souvenir->souvenir_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus souvenir ini?')" class="inline">
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
        <!-- USER INTERFACE (Katalog Souvenir dengan Fitur Pengurutan/Kategori) -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Pilihan Souvenir</h1>
                <p class="text-sm text-[#5C6E65]">Temukan cinderamata otentik khas daerah untuk melengkapi perjalanan Anda</p>
            </div>

            <!-- Category / Sorting Menu -->
            <div class="flex flex-wrap items-center gap-2 border-b border-[#E6E4DD] pb-4">
                <a href="{{ route('user.souvenir') }}" 
                   class="px-4 py-2 text-xs font-semibold rounded-lg transition-all duration-150 border {{ empty($kategori) ? 'bg-[#2B4C3F] text-white border-[#2B4C3F]' : 'bg-white hover:bg-[#FAF9F6] text-[#5C6E65] border-[#E6E4DD]' }}">
                    Semua Produk
                </a>
                <a href="{{ route('user.souvenir', ['kategori' => 'terlaris']) }}" 
                   class="px-4 py-2 text-xs font-semibold rounded-lg transition-all duration-150 border {{ $kategori === 'terlaris' ? 'bg-[#2B4C3F] text-white border-[#2B4C3F]' : 'bg-white hover:bg-[#FAF9F6] text-[#5C6E65] border-[#E6E4DD]' }} flex items-center gap-1.5">
                    <span>🔥</span> Terlaris
                </a>
            </div>

            @if($souvenirs->isEmpty())
                <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 sm:p-12 text-center flex flex-col items-center justify-center">
                    <span class="text-5xl mb-4">🏺</span>
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Souvenir Belum Tersedia</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm">
                        Kami sedang menyiapkan beberapa pilihan produk souvenir terbaik untuk Anda. Silakan kembali beberapa saat lagi!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($souvenirs as $souvenir)
                        <div class="bg-white rounded-2xl overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                            <div>
                                <div class="h-48 overflow-hidden relative">
                                    @if($souvenir->foto)
                                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-[#FAF9F6] border-b border-[#E6E4DD] flex items-center justify-center text-5xl">🏺</div>
                                    @endif
                                    
                                    @if($souvenir->status === 'Tersedia' && $souvenir->stok > 0)
                                        <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">Tersedia</span>
                                    @else
                                        <span class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-white px-2.5 py-1 rounded-full shadow-sm">Habis</span>
                                    @endif

                                    <!-- Badge jumlah_terjual (dari sistem transaksi) -->
                                    @if($souvenir->jumlah_terjual > 0)
                                        <span class="absolute top-4 right-4 bg-amber-500/95 backdrop-blur-sm text-[10px] font-bold text-white px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1">
                                            🔥 {{ $souvenir->jumlah_terjual }} Terjual
                                        </span>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h4 class="font-serif font-semibold text-lg text-[#2C3E35] mb-1">{{ $souvenir->nama_souvenir }}</h4>
                                    <p class="text-xs text-[#8A9C91] mb-2">Stok: {{ $souvenir->stok }} pcs</p>
                                    @if($souvenir->detail)
                                        <p class="text-xs text-[#5C6E65] line-clamp-3 mb-4 leading-relaxed">
                                            {{ $souvenir->detail }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                                    <div>
                                        <span class="text-[10px] text-[#8A9C91] block">Harga</span>
                                        <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                    </div>
                                    @if($souvenir->status === 'Tersedia' && $souvenir->stok > 0)
                                        <a href="#" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                                            Beli
                                        </a>
                                    @else
                                        <button disabled class="px-4 py-2 bg-[#FAF9F6] border border-[#E6E4DD] text-[#8A9C91] text-xs font-semibold rounded-lg cursor-not-allowed">
                                            Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
