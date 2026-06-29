@extends('layouts.user')

@section('title', 'Pembayaran Pesanan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
            <a href="{{ route('user.pesanan.show', $pemesanan->pemesanan_id) }}" class="text-xs font-semibold text-[#5C6E65] hover:text-[#2B4C3F]">
                &larr; Kembali ke Detail Pesanan
            </a>
            <h2 class="font-serif text-3xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-4">
                Pembayaran
            </h2>
            <p class="text-sm text-[#5C6E65] mt-2">
                Upload bukti pembayaran untuk pesanan {{ $pemesanan->kode_pemesanan }}.
            </p>

            <div class="mt-6 p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl flex justify-between gap-4">
                <span class="text-sm text-[#5C6E65]">Total Tagihan</span>
                <span class="font-bold text-[#E65F5F]">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('user.pembayaran.store', $pemesanan->pemesanan_id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="metode_pembayaran" class="block text-sm font-semibold text-[#2C3E35] mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran"
                        class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                        <option value="transfer_bank" @selected(old('metode_pembayaran') === 'transfer_bank')>Transfer Bank</option>
                        <option value="qris_manual" @selected(old('metode_pembayaran') === 'qris_manual')>QRIS Manual</option>
                        <option value="tunai" @selected(old('metode_pembayaran') === 'tunai')>Tunai</option>
                    </select>
                    @error('metode_pembayaran')
                        <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah_bayar" class="block text-sm font-semibold text-[#2C3E35] mb-2">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" min="1" value="{{ old('jumlah_bayar', (int) $pemesanan->total_harga) }}"
                        class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                    @error('jumlah_bayar')
                        <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bukti_pembayaran" class="block text-sm font-semibold text-[#2C3E35] mb-2">Bukti Pembayaran</label>
                    <label for="bukti_pembayaran"
                        class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-[#C9D8D0] bg-[#FAF9F6] px-6 py-8 text-center transition-all hover:border-[#2B4C3F] hover:bg-[#F3F7F5]">
                        <span class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[#EAF2EE] text-[#2B4C3F] transition-all group-hover:bg-[#2B4C3F] group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0l-4 4m4-4l4 4" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold text-[#2C3E35]" id="bukti-file-label">
                            Pilih bukti pembayaran
                        </span>
                        <span class="mt-1 text-xs text-[#8A9C91]">
                            JPG, PNG, atau WEBP maksimal 2MB
                        </span>
                    </label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" class="sr-only">
                    @error('bukti_pembayaran')
                        <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-[#2B4C3F] hover:bg-[#1E362C] text-white text-sm font-semibold py-4 px-4 rounded-xl shadow-sm transition-all">
                    Kirim Pembayaran
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('bukti_pembayaran');
            const label = document.getElementById('bukti-file-label');

            if (!input || !label) return;

            input.addEventListener('change', function () {
                const file = input.files && input.files[0];
                label.textContent = file ? file.name : 'Pilih bukti pembayaran';
            });
        });
    </script>
@endsection
