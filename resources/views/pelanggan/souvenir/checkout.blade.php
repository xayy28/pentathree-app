@extends('layouts.user')

@section('title', 'Checkout Souvenir')

@section('content')
    @php
        $subtotal = $items->sum(function ($item) {
            return $item->souvenir->harga * $item->quantity;
        });
        $serviceFee = 5000;
        $total = $subtotal + $serviceFee;
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="mb-8">
            <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase">
                Checkout
            </h2>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                    <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Alamat Pengiriman</h3>
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="text-[#2C3E35]">
                            <p class="font-bold mb-1">
                                {{ auth()->user()->nama }}
                                <span class="font-normal text-[#8A9C91]">{{ auth()->user()->no_hp }}</span>
                            </p>
                            <p class="text-sm text-[#5C6E65]">{{ auth()->user()->alamat }}</p>
                        </div>
                        <button type="button" class="text-sm text-[#2B4C3F] font-semibold hover:underline border border-[#2B4C3F] px-4 py-1.5 rounded-lg">
                            Ubah
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                    <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Produk Dipesan</h3>

                    <div class="space-y-4">
                        @forelse ($items as $item)
                            @php
                                $souvenir = $item->souvenir;
                                $itemTotal = $souvenir->harga * $item->quantity;
                            @endphp
                            <div class="flex items-center gap-4 border-b border-[#F2F0EA] pb-4 last:border-0 last:pb-0">
                                <div class="w-16 h-16 bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40 rounded-lg overflow-hidden">
                                    @if ($souvenir->foto)
                                        <img src="{{ asset($souvenir->foto) }}" alt="{{ $souvenir->nama_souvenir }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-[#8A9C91] bg-[#FAF9F6]">Item</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-[#2C3E35] truncate">{{ $souvenir->nama_souvenir }}</h4>
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

                <div class="bg-white rounded-2xl p-6 border border-[#E6E4DD]/60 shadow-sm">
                    <h3 class="font-serif font-semibold text-lg text-[#2C3E35] mb-4">Opsi Pengiriman</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                            <input type="radio" name="pengiriman" value="pickup" class="sr-only" checked>
                            <div class="flex flex-col">
                                <span class="block text-sm font-bold text-[#2C3E35]">Jemput Sendiri</span>
                                <span class="mt-1 text-xs text-[#8A9C91]">Ambil di Natasha Homestay</span>
                                <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 0</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                            <input type="radio" name="pengiriman" value="ekspedisi" class="sr-only">
                            <div class="flex flex-col">
                                <span class="block text-sm font-bold text-[#2C3E35]">Ekspedisi Reguler</span>
                                <span class="mt-1 text-xs text-[#8A9C91]">JNE / J&T / Sicepat</span>
                                <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 15.000</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border bg-white p-4 shadow-sm hover:border-[#2B4C3F] has-[:checked]:border-[#2B4C3F] has-[:checked]:ring-1 has-[:checked]:ring-[#2B4C3F]">
                            <input type="radio" name="pengiriman" value="instan" class="sr-only">
                            <div class="flex flex-col">
                                <span class="block text-sm font-bold text-[#2C3E35]">Pengiriman Instan</span>
                                <span class="mt-1 text-xs text-[#8A9C91]">Gojek / Grab</span>
                                <span class="mt-2 block text-sm font-semibold text-[#2B4C3F]">Rp 20.000</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-[#E6E4DD]/60 shadow-sm sticky top-24">
                <h3 class="font-serif text-xl font-semibold text-[#2C3E35] border-b border-[#F2F0EA] pb-4 mb-4">
                    Ringkasan Belanja
                </h3>

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

                    <div class="border-t border-[#F2F0EA] pt-4 flex justify-between items-center gap-4">
                        <span class="text-base font-bold text-[#2C3E35]">Total Tagihan</span>
                        <span class="text-xl font-bold text-[#E65F5F]" id="total-bill">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-4 px-4 rounded-xl shadow-sm transition-all duration-300 flex items-center justify-center">
                        Buat Pesanan
                    </button>
                </div>

                <p class="text-[10px] text-center text-[#8A9C91] mt-4 leading-relaxed">
                    Pembayaran dipilih setelah pesanan dibuat.
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
                return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function updateSummary() {
                const selectedShipping = document.querySelector('input[name="pengiriman"]:checked').value;
                let shippingFee = 0;

                if (selectedShipping === 'ekspedisi') {
                    shippingFee = 15000;
                } else if (selectedShipping === 'instan') {
                    shippingFee = 20000;
                }

                shippingFeeElement.textContent = formatRupiah(shippingFee);
                totalBillElement.textContent = formatRupiah(subtotal + serviceFee + shippingFee);
            }

            shippingRadios.forEach(function (radio) {
                radio.addEventListener('change', updateSummary);
            });
        });
    </script>
@endsection
