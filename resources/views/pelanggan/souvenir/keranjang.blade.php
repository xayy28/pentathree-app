@extends('layouts.user')

@section('title', 'Keranjang Belanja Souvenir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 bg-[#F8F7F4]">

    <!-- Header Section -->
    <div class="text-center space-y-4">
        <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
            Keranjang Belanja
        </h2>
        <p class="text-sm text-[#5C6E65] max-w-2xl mx-auto leading-relaxed">
            Kelola souvenir pilihan Anda sebelum melanjutkan ke proses pembayaran (checkout).
        </p>
    </div>

    @if($items->isEmpty())
        <!-- Empty State -->
        <div class="max-w-md mx-auto bg-white rounded-3xl border border-[#E6E4DD] p-12 text-center flex flex-col items-center justify-center shadow-sm">
            <span class="text-6xl mb-6">🛒</span>
            <h3 class="text-xl font-serif font-semibold text-[#2C3E35] mb-2">Keranjang Anda Kosong</h3>
            <p class="text-xs text-[#8A9C91] mb-6 max-w-xs leading-relaxed">
                Sepertinya Anda belum menambahkan souvenir apa pun ke keranjang belanja Anda.
            </p>
            <a href="{{ route('user.souvenir') }}" class="inline-flex items-center justify-center bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-xs font-semibold py-3 px-6 rounded-xl shadow-sm transition-all duration-300 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Lihat Katalog Souvenir</span>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <!-- Left Column: Cart Items List -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($items as $item)
                    @php
                        $souvenir = $item->souvenir;
                        $itemTotal = $souvenir->harga * $item->quantity;
                    @endphp
                    <div class="bg-white rounded-3xl p-6 border border-[#E6E4DD]/60 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6 transition-all duration-300 hover:shadow-md">
                        
                        <!-- Product Info (Image + Title + Price) -->
                        <div class="flex items-center gap-5 w-full sm:w-auto">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40">
                                @if($souvenir->foto)
                                    <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl bg-[#FAF9F6]">🏺</div>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <h4 class="font-serif font-semibold text-lg text-[#2C3E35]">
                                    {{ $souvenir->nama_souvenir }}
                                </h4>
                                <div class="text-xs text-[#8A9C91]">
                                    Harga: <span class="font-semibold text-[#2B4C3F]">Rp {{ number_format($souvenir->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-[10px] text-[#8A9C91]">
                                    Stok tersedia: {{ $souvenir->stok }} pcs
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Control and Action -->
                        <div class="flex items-center justify-between sm:justify-end gap-8 w-full sm:w-auto border-t sm:border-t-0 pt-4 sm:pt-0 border-[#F2F0EA]">
                            
                            <!-- Quantity Form -->
                            <div class="flex items-center border border-[#E6E4DD] rounded-xl overflow-hidden bg-[#FAF9F6]">
                                <!-- Button Decrease -->
                                <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                    <button type="submit" class="px-3 py-2 text-gray-500 hover:bg-[#EAF2EE] hover:text-[#2B4C3F] transition-all disabled:opacity-30 disabled:cursor-not-allowed" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Quantity Display -->
                                <span class="px-4 py-1 text-sm font-semibold text-[#2C3E35] select-none min-w-[32px] text-center">
                                    {{ $item->quantity }}
                                </span>

                                <!-- Button Increase -->
                                <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                    <button type="submit" class="px-3 py-2 text-gray-500 hover:bg-[#EAF2EE] hover:text-[#2B4C3F] transition-all disabled:opacity-30 disabled:cursor-not-allowed" {{ $item->quantity >= $souvenir->stok ? 'disabled' : '' }}>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Item Total & Trash Btn -->
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <span class="text-[9px] text-[#8A9C91] block uppercase tracking-wider">Subtotal</span>
                                    <span class="text-sm font-bold text-[#2B4C3F]">
                                        Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-[#E65F5F] hover:bg-[#FDF2F2] hover:text-[#B91C1C] rounded-xl transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column: Order Summary -->
            @php
                $subtotal = $items->sum(function($item) {
                    return $item->souvenir->harga * $item->quantity;
                });
                $serviceFee = 5000;
                $total = $subtotal + $serviceFee;
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-[#E6E4DD]/60 shadow-sm space-y-6">
                <h3 class="font-serif text-xl font-semibold text-[#2C3E35] border-b border-[#F2F0EA] pb-4">
                    Ringkasan Belanja
                </h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-[#5C6E65]">
                        <span>Subtotal ({{ $items->sum('quantity') }} barang)</span>
                        <span class="font-medium text-[#2C3E35]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-[#5C6E65]">
                        <span>Biaya Pengemasan & Layanan</span>
                        <span class="font-medium text-[#2C3E35]">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-[#F2F0EA] pt-4 flex justify-between">
                        <span class="text-base font-semibold text-[#2C3E35]">Total Harga</span>
                        <span class="text-lg font-bold text-[#2B4C3F]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="#" class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-3.5 px-4 rounded-xl shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Lanjut ke Checkout</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="text-center">
                    <a href="{{ route('user.souvenir') }}" class="text-xs text-[#5C6E65] hover:text-[#2B4C3F] font-semibold transition-colors">
                        ← Kembali Belanja
                    </a>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
