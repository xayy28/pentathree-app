@extends('layouts.app')

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
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-xs uppercase tracking-wider">
                                <th class="pb-3 w-24">Foto</th>
                                <th class="pb-3">Nama Homestay</th>
                                <th class="pb-3">Harga / Malam</th>
                                <th class="pb-3">Kapasitas</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                            @foreach($homestays as $homestay)
                                <tr class="hover:bg-[#FAF9F6] transition-colors group">
                                    <td class="py-4 pr-4">
                                        @if($homestay->foto)
                                            <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-16 h-12 object-cover rounded-lg border border-[#E6E4DD]">
                                        @else
                                            <div class="w-16 h-12 bg-[#FAF9F6] border border-[#E6E4DD] rounded-lg flex items-center justify-center text-lg">🏠</div>
                                        @endif
                                    </td>
                                    <td class="py-4 font-serif font-semibold text-base text-[#2C3E35]">
                                        {{ $homestay->nama_homestay }}
                                        @if($homestay->detail)
                                            <span class="block text-xs font-sans font-normal text-[#8A9C91] max-w-xs truncate" title="{{ $homestay->detail }}">
                                                {{ $homestay->detail }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 font-semibold text-[#2B4C3F]">
                                        Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-[#5C6E65]">
                                        {{ $homestay->kapasitas }} Orang
                                    </td>
                                    <td class="py-4">
                                        @if($homestay->status === 'Tersedia')
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C]">
                                                {{ $homestay->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.homestay.edit', $homestay->homestay_id) }}" class="p-2 text-[#5C6E65] hover:text-[#2B4C3F] hover:bg-[#FAF9F6] border border-transparent hover:border-[#E6E4DD] rounded-lg transition-all" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.homestay.destroy', $homestay->homestay_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus homestay ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-[#E65F5F] hover:text-white hover:bg-[#E65F5F] rounded-lg transition-all" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
        <!-- USER INTERFACE (Katalog Homestay) -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Rekomendasi Homestay</h1>
                <p class="text-sm text-[#5C6E65]">Jelajahi penginapan estetik dengan kenyamanan premium terbaik</p>
            </div>

            @if($homestays->isEmpty())
                <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 sm:p-12 text-center flex flex-col items-center justify-center">
                    <span class="text-5xl mb-4">🏠</span>
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Homestay Belum Tersedia</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm">
                        Kami sedang menyiapkan beberapa pilihan homestay terbaik untuk Anda. Silakan kembali beberapa saat lagi!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($homestays as $homestay)
                        <div class="bg-white rounded-2xl overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                            <div>
                                <div class="h-48 overflow-hidden relative">
                                    @if($homestay->foto)
                                        <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-[#FAF9F6] border-b border-[#E6E4DD] flex items-center justify-center text-5xl">🏠</div>
                                    @endif
                                    @if($homestay->status === 'Tersedia')
                                        <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">Tersedia</span>
                                    @else
                                        <span class="absolute top-4 left-4 bg-[#E65F5F]/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-white px-2.5 py-1 rounded-full shadow-sm">{{ $homestay->status }}</span>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h4 class="font-serif font-semibold text-lg text-[#2C3E35] mb-1">{{ $homestay->nama_homestay }}</h4>
                                    <p class="text-xs text-[#8A9C91] mb-2">Kapasitas: {{ $homestay->kapasitas }} Orang</p>
                                    @if($homestay->detail)
                                        <p class="text-xs text-[#5C6E65] line-clamp-3 mb-4 leading-relaxed">
                                            {{ $homestay->detail }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                                    <div>
                                        <span class="text-[10px] text-[#8A9C91] block">Harga / malam</span>
                                        <span class="text-sm font-semibold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                                    </div>
                                    @if($homestay->status === 'Tersedia')
                                        <a href="#" class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                                            Pesan
                                        </a>
                                    @else
                                        <button disabled class="px-4 py-2 bg-[#FAF9F6] border border-[#E6E4DD] text-[#8A9C91] text-xs font-semibold rounded-lg cursor-not-allowed">
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
    @endif

</div>
@endsection
