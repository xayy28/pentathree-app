@extends('layouts.user')

@section('title', 'Checkout Souvenir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
            Checkout
        </h2>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        @csrf
        
        <!-- Kolom Kiri: Alamat, Produk, Pengiriman, Pembayaran -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Alamat Pengiriman -->
            <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm relative overflow-hidden">
                <!-- Aksen Garis Alamat -->
                <div class="absolute top-0 left-0 w-full h-1 bg-[repeating-linear-gradient(45deg,#E65F5F,#E65F5F_30px,transparent_30px,transparent_40px,#4299E1_40px,#4299E1_70px,transparent_70px,transparent_80px)]"></div>
                
                <div class="flex items-center gap-2 text-[#E65F5F] font-semibold mb-4 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-lg">Alamat Pengiriman</span>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="text-[#2C3E35]">
                        <p class="font-bold mb-1">{{ auth()->user()->nama }} <span class="font-normal text-[#8A9C91]">{{ auth()->user()->no_hp }}</span></p>
                        <p class="text-sm text-[#5C6E65]">{{ auth()->user()->alamat }}</p>
                    </div>
                    <button type="button" class="text-sm text-[#2B4C3F] font-semibold hover:underline border border-[#2B4C3F] px-4 py-1.5 rounded-lg">Ubah</button>
                </div>
            </div>

            <!-- Produk yang Dipesan -->
            <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Produk Dipesan</h3>
                
                <div class="space-y-4">
                    @forelse($items as $item)
                        @php
                            $souvenir = $item->souvenir;
                            $itemTotal = $souvenir->harga * $item->quantity;
                        @endphp
                        <div class="flex items-center gap-4 border-b border-[#F2F0EA] pb-4 last:border-0 last:pb-0">
                            <div class="w-16 h-16 bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40 rounded-lg overflow-hidden">
                                @if($souvenir->foto)
                                    <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl bg-[#FAF9F6]">🏺</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-[#2C3E35]">{{ $souvenir->nama_souvenir }}</h4>
                                <p class="text-xs text-[#8A9C91]">Kuantitas: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#2B4C3F]">Rp {{ number_format($itemTotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-[#8A9C91] py-4">Belum ada produk di keranjang.</p>
                    @endforelse
                </div>
            </div>

            <!-- Opsi Pengiriman -->
            <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Opsi Pengiriman</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Jemput di Tempat -->
                    <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm focus:outline-none hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                        <input type="radio" name="pengiriman" value="pickup" class="sr-only" checked>
                        <div class="flex flex-col">
                            <span class="block text-sm font-bold text-[#2C3E35]">Jemput Sendiri</span>
                            <span class="mt-1 flex items-center text-xs text-[#8A9C91]">Ambil di Natasha Homestay</span>
                            <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 0</span>
                        </div>
                        <div class="absolute right-4 top-4 text-[#2B4C3F] opacity-0 has-[:checked]:opacity-100">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>

                    <!-- Ekspedisi -->
                    <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm focus:outline-none hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                        <input type="radio" name="pengiriman" value="ekspedisi" class="sr-only">
                        <div class="flex flex-col">
                            <span class="block text-sm font-bold text-[#2C3E35]">Ekspedisi Reguler</span>
                            <span class="mt-1 flex items-center text-xs text-[#8A9C91]">JNE / J&T / Sicepat</span>
                            <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 15.000</span>
                        </div>
                        <div class="absolute right-4 top-4 text-[#2B4C3F] opacity-0 has-[:checked]:opacity-100">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>

                    <!-- Instan -->
                    <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm focus:outline-none hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                        <input type="radio" name="pengiriman" value="instan" class="sr-only">
                        <div class="flex flex-col">
                            <span class="block text-sm font-bold text-[#2C3E35]">Pengiriman Instan</span>
                            <span class="mt-1 flex items-center text-xs text-[#8A9C91]">Gojek / Grab</span>
                            <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 20.000</span>
                        </div>
                        <div class="absolute right-4 top-4 text-[#2B4C3F] opacity-0 has-[:checked]:opacity-100">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Metode Pembayaran</h3>
                
                <div class="space-y-3">
                    <!-- QRIS -->
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:bg-[#FAF9F6] transition-colors has-[:checked]:border-[#2B4C3F] has-[:checked]:bg-[#EAF2EE]">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="pembayaran" value="qris" class="w-4 h-4 text-[#2B4C3F] bg-gray-100 border-gray-300 focus:ring-[#2B4C3F]" checked>
                            <div>
                                <p class="font-bold text-[#2C3E35]">QRIS</p>
                                <p class="text-xs text-[#8A9C91]">Scan QR dengan M-Banking atau E-Wallet</p>
                            </div>
                        </div>
                        <div class="bg-[#2B4C3F]/10 text-[#2B4C3F] text-xs font-bold px-2 py-1 rounded">Instan</div>
                    </label>

                    <!-- Transfer Bank -->
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:bg-[#FAF9F6] transition-colors has-[:checked]:border-[#2B4C3F] has-[:checked]:bg-[#EAF2EE]">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="pembayaran" value="transfer" class="w-4 h-4 text-[#2B4C3F] bg-gray-100 border-gray-300 focus:ring-[#2B4C3F]">
                            <div>
                                <p class="font-bold text-[#2C3E35]">Transfer Bank</p>
                                <p class="text-xs text-[#8A9C91]">Transfer Manual (BCA, BNI, Mandiri, BRI)</p>
                            </div>
                        </div>
                        <div class="text-2xl">🏦</div>
                    </label>

                    <!-- E-Money -->
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:bg-[#FAF9F6] transition-colors has-[:checked]:border-[#2B4C3F] has-[:checked]:bg-[#EAF2EE]">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="pembayaran" value="emoney" class="w-4 h-4 text-[#2B4C3F] bg-gray-100 border-gray-300 focus:ring-[#2B4C3F]">
                            <div>
                                <p class="font-bold text-[#2C3E35]">E-Money</p>
                                <p class="text-xs text-[#8A9C91]">Gopay, OVO, Dana, LinkAja</p>
                            </div>
                        </div>
                        <div class="text-2xl">📱</div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Ringkasan Pesanan -->
        <div class="bg-white rounded-3xl p-6 border border-[#E6E4DD]/60 shadow-sm sticky top-24">
            <h3 class="font-serif text-xl font-semibold text-[#2C3E35] border-b border-[#F2F0EA] pb-4 mb-4">
                Ringkasan Belanja
            </h3>
            
            @php
                $subtotal = $items->sum(function($item) {
                    return $item->souvenir->harga * $item->quantity;
                });
                $serviceFee = 5000;
                $shippingFee = 0; // Default
                $total = $subtotal + $serviceFee + $shippingFee;
            @endphp
            
            <div class="space-y-4">
                <div class="flex justify-between text-sm text-[#5C6E65]">
                    <span>Total Harga ({{ $items->sum('quantity') }} barang)</span>
                    <span class="font-medium text-[#2C3E35]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-[#5C6E65]">
                    <span>Total Ongkos Kirim</span>
                    <span class="font-medium text-[#2C3E35]" id="shipping-fee">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-[#5C6E65]">
                    <span>Biaya Layanan</span>
                    <span class="font-medium text-[#2C3E35]">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                </div>
                
                <div class="border-t border-[#F2F0EA] pt-4 flex justify-between items-center">
                    <span class="text-base font-bold text-[#2C3E35]">Total Tagihan</span>
                    <span class="text-xl font-bold text-[#E65F5F]" id="total-bill">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-4 px-4 rounded-xl shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                    Buat Pesanan
                </button>
            </div>
            
            <p class="text-[10px] text-center text-[#8A9C91] mt-4 leading-relaxed">
                Dengan melanjutkan, Anda menyetujui Syarat dan Ketentuan Natasha Homestay.
            </p>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shippingRadios = document.querySelectorAll('input[name="pengiriman"]');
        const shippingFeeElement = document.getElementById('shipping-fee');
        const totalBillElement = document.getElementById('total-bill');
        
        const subtotal = {{ $subtotal }};
        const serviceFee = {{ $serviceFee }};
        
        function formatRupiah(amount) {
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function updateSummary() {
            let shippingFee = 0;
            const selectedShipping = document.querySelector('input[name="pengiriman"]:checked').value;
            
            if (selectedShipping === 'ekspedisi') {
                shippingFee = 15000;
            } else if (selectedShipping === 'instan') {
                shippingFee = 20000;
            } else {
                shippingFee = 0;
            }
            
            const totalBill = subtotal + serviceFee + shippingFee;
            
            shippingFeeElement.textContent = formatRupiah(shippingFee);
            totalBillElement.textContent = formatRupiah(totalBill);
        }
        
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', updateSummary);
        });
    });
</script>
@endsection
