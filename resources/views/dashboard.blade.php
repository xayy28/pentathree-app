@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-[#2B4C3F] to-[#1E362C] rounded-2xl p-6 sm:p-10 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-10 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-white to-transparent pointer-events-none"></div>
        <div>
            <h1 class="text-3xl font-serif font-semibold mb-2">Halo, {{ auth()->user()->nama }}!</h1>
            <p class="text-[#A7C5B5] text-sm max-w-xl leading-relaxed">
                Temukan penginapan impian Anda dan belanja kerajinan lokal khas dari koleksi terbaik kami.
            </p>
        </div>
        <div class="flex-shrink-0">
            <span class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-xs font-semibold tracking-wider uppercase text-white">
                Member sejak {{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : date('M Y') }}
            </span>
        </div>
    </div>

    <!-- Main Grid: Profile & Order History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-[#EAF2EE] rounded-full flex items-center justify-center border border-[#A7C5B5] text-[#2B4C3F] font-semibold text-lg">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-serif font-semibold text-lg text-[#2C3E35]">{{ auth()->user()->nama }}</h3>
                        <p class="text-xs font-mono font-bold text-[#2B4C3F]">{{ auth()->user()->user_id }}</p>
                    </div>
                </div>

                <div class="space-y-4 text-sm border-t border-[#F2F0EA] pt-4">
                    <div>
                        <span class="text-xs text-[#8A9C91] block">Email Address</span>
                        <span class="text-[#2C3E35] font-medium">{{ auth()->user()->email }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-[#8A9C91] block">Phone Number</span>
                        <span class="text-[#2C3E35] font-medium">{{ auth()->user()->no_hp }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-[#8A9C91] block">Delivery Address</span>
                        <p class="text-[#2C3E35] font-medium mt-0.5 leading-relaxed">
                            {{ auth()->user()->alamat }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-[#F2F0EA]">
                <button class="w-full py-2.5 bg-[#FAF9F6] border border-[#D5D3C7] hover:bg-[#F2F0EA] rounded-lg text-xs font-semibold text-[#2C3E35] transition-colors">
                    Edit Profil Singkat
                </button>
            </div>
        </div>

        <!-- Order History Table (Span 2) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-serif font-semibold text-[#2C3E35]">Riwayat Pesanan</h3>
                    <p class="text-xs text-[#8A9C91]">Aktivitas reservasi homestay dan souvenir Anda</p>
                </div>
                <span class="text-xs font-semibold text-[#2B4C3F] hover:underline cursor-pointer">Lihat Riwayat Lengkap</span>
            </div>

            <!-- Desktop: Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-[#E6E4DD] text-[#8A9C91] font-semibold text-xs uppercase tracking-wider">
                            <th class="pb-3">No. Invoice</th>
                            <th class="pb-3">Item/Layanan</th>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F0EA] text-[#2C3E35]">
                        <tr class="hover:bg-[#FAF9F6] transition-colors">
                            <td class="py-3.5 font-semibold text-[#2B4C3F]">#INV-1092</td>
                            <td class="py-3.5">
                                <div class="font-medium text-[#2C3E35]">Green Valley Lodge</div>
                                <span class="text-[10px] text-[#8A9C91]">2 Malam &bull; Homestay</span>
                            </td>
                            <td class="py-3.5 text-[#5C6E65]">14 Jan 2026</td>
                            <td class="py-3.5 font-medium text-[#2C3E35]">Rp 1.450.000</td>
                            <td class="py-3.5">
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-[#FAF9F6] transition-colors">
                            <td class="py-3.5 font-semibold text-[#2B4C3F]">#INV-1087</td>
                            <td class="py-3.5">
                                <div class="font-medium text-[#2C3E35]">Gantungan Kunci Ukiran & Kain Tenun</div>
                                <span class="text-[10px] text-[#8A9C91]">3 Pcs &bull; Souvenir</span>
                            </td>
                            <td class="py-3.5 text-[#5C6E65]">08 Jan 2026</td>
                            <td class="py-3.5 font-medium text-[#2C3E35]">Rp 280.000</td>
                            <td class="py-3.5">
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]">
                                    Diproses
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile/Tablet: Cards -->
            <div class="lg:hidden space-y-3">
                <div class="bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] p-4">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-xs font-bold text-[#2B4C3F]">#INV-1092</span>
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#EAF2EE] text-[#2B4C3F]">Lunas</span>
                    </div>
                    <div class="text-sm font-medium text-[#2C3E35]">Green Valley Lodge</div>
                    <span class="text-[10px] text-[#8A9C91]">2 Malam &bull; Homestay</span>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#E6E4DD]">
                        <span class="text-[11px] text-[#5C6E65]">14 Jan 2026</span>
                        <span class="text-sm font-semibold text-[#2C3E35]">Rp 1.450.000</span>
                    </div>
                </div>
                <div class="bg-[#FAF9F6] rounded-xl border border-[#E6E4DD] p-4">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-xs font-bold text-[#2B4C3F]">#INV-1087</span>
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#FAF9F6] border border-[#E6E4DD] text-[#5C6E65]">Diproses</span>
                    </div>
                    <div class="text-sm font-medium text-[#2C3E35]">Gantungan Kunci Ukiran & Kain Tenun</div>
                    <span class="text-[10px] text-[#8A9C91]">3 Pcs &bull; Souvenir</span>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#E6E4DD]">
                        <span class="text-[11px] text-[#5C6E65]">08 Jan 2026</span>
                        <span class="text-sm font-semibold text-[#2C3E35]">Rp 280.000</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Section: Homestay Menu -->
    <div class="space-y-6">
        <div>
            <h3 class="text-2xl font-serif font-semibold text-[#2C3E35]">Rekomendasi Homestay</h3>
            <p class="text-xs text-[#5C6E65]">Jelajahi penginapan estetik dengan kenyamanan premium terbaik</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-md transition-shadow group">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=85" alt="Homestay" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#2B4C3F] px-2.5 py-1 rounded-full shadow-sm">Terpopuler</span>
                </div>
                <div class="p-6">
                    <h4 class="font-serif font-semibold text-lg text-[#2C3E35] mb-1">Aura Cozy Retreat</h4>
                    <p class="text-xs text-[#8A9C91] mb-4">Lembang, Bandung</p>
                    <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                        <div>
                            <span class="text-[10px] text-[#8A9C91] block">Mulai dari</span>
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 750.000 / malam</span>
                        </div>
                        <button class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                            Pesan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl overflow-hidden border border-[#E6E4DD] shadow-sm hover:shadow-md transition-shadow group">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=85" alt="Homestay" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h4 class="font-serif font-semibold text-lg text-[#2C3E35] mb-1">Rustic Green Lodge</h4>
                    <p class="text-xs text-[#8A9C91] mb-4">Puncak, Bogor</p>
                    <div class="flex items-center justify-between border-t border-[#F2F0EA] pt-4">
                        <div>
                            <span class="text-[10px] text-[#8A9C91] block">Mulai dari</span>
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 900.000 / malam</span>
                        </div>
                        <button class="px-4 py-2 bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold rounded-lg transition-colors">
                            Pesan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Section: Souvenir Menu -->
    <div class="space-y-6">
        <div>
            <h3 class="text-2xl font-serif font-semibold text-[#2C3E35]">Katalog Souvenir Terpopuler</h3>
            <p class="text-xs text-[#5C6E65]">Bawa pulang buah tangan hasil kerajinan pengrajin lokal pilihan</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            
            <!-- Souvenir Item 1 -->
            <div class="bg-white rounded-2xl border border-[#E6E4DD] overflow-hidden p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="bg-[#FAF9F6] rounded-xl h-36 flex items-center justify-center text-5xl mb-4 border border-[#F2F0EA]">
                        🏺
                    </div>
                    <h4 class="font-semibold text-sm text-[#2C3E35] mb-1">Guci Tanah Liat Klasik</h4>
                    <span class="text-[10px] text-[#8A9C91]">Gerabah Lokal</span>
                </div>
                <div class="mt-4 pt-3 border-t border-[#F2F0EA] flex items-center justify-between">
                    <span class="text-xs font-bold text-[#2B4C3F]">Rp 120.000</span>
                    <button class="p-2 bg-[#EAF2EE] text-[#2B4C3F] hover:bg-[#2B4C3F] hover:text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Souvenir Item 2 -->
            <div class="bg-white rounded-2xl border border-[#E6E4DD] overflow-hidden p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="bg-[#FAF9F6] rounded-xl h-36 flex items-center justify-center text-5xl mb-4 border border-[#F2F0EA]">
                        🧣
                    </div>
                    <h4 class="font-semibold text-sm text-[#2C3E35] mb-1">Syal Kain Tenun Tradisional</h4>
                    <span class="text-[10px] text-[#8A9C91]">Tekstil Lokal</span>
                </div>
                <div class="mt-4 pt-3 border-t border-[#F2F0EA] flex items-center justify-between">
                    <span class="text-xs font-bold text-[#2B4C3F]">Rp 180.000</span>
                    <button class="p-2 bg-[#EAF2EE] text-[#2B4C3F] hover:bg-[#2B4C3F] hover:text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
