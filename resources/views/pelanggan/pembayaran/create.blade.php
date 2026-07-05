@extends('layouts.user')

@section('title', 'Pembayaran Pesanan')

@section('content')
    @php
        $manualMethods = ['transfer_bank', 'qris_manual', 'tunai'];
        $isMidtransLocked = $pemesanan->pembayaran?->metode_pembayaran === 'midtrans';
        $selectedPaymentPanel = ! $isMidtransLocked && ($errors->any() || in_array(old('metode_pembayaran'), $manualMethods, true)) ? 'manual' : 'midtrans';
    @endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
            <a href="{{ route('user.pesanan.index') }}" class="text-xs font-semibold text-[#5C6E65] hover:text-[#2B4C3F]">
                &larr; Kembali ke Riwayat Pesanan
            </a>
            <h2 class="font-serif text-3xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-4">
                Pembayaran
            </h2>
            <p class="text-sm text-[#5C6E65] mt-2">
                Pesanan {{ $pemesanan->kode_pemesanan }} siap dibayar.
            </p>

            <div class="mt-6 p-4 bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl flex justify-between gap-4">
                <span class="text-sm text-[#5C6E65]">Total Tagihan</span>
                <span class="font-bold text-[#E65F5F]">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
            </div>

            <div id="payment-method-lock-notice"
                class="mt-6 rounded-xl border border-[#F2D8A8] bg-[#FFF8E8] p-4 text-sm text-[#8A5A10] {{ $isMidtransLocked ? '' : 'hidden' }}">
                Metode pembayaran sudah dikunci ke Midtrans untuk pesanan ini.
            </div>

            @if (! $isMidtransLocked)
                <div id="payment-method-switcher" class="mt-6">
                    <div class="grid grid-cols-2 gap-2 rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] p-1">
                        <button type="button" data-payment-tab="midtrans"
                            class="payment-tab h-12 rounded-lg px-3 text-sm font-semibold transition-all {{ $selectedPaymentPanel === 'midtrans' ? 'bg-[#2B4C3F] text-white shadow-sm' : 'text-[#5C6E65] hover:bg-white' }}">
                            Midtrans Online
                        </button>
                        <button type="button" data-payment-tab="manual"
                            class="payment-tab h-12 rounded-lg px-3 text-sm font-semibold transition-all {{ $selectedPaymentPanel === 'manual' ? 'bg-[#2B4C3F] text-white shadow-sm' : 'text-[#5C6E65] hover:bg-white' }}">
                            Transfer Manual
                        </button>
                    </div>
                </div>
            @endif

            <div data-payment-panel="midtrans" class="{{ $selectedPaymentPanel === 'midtrans' ? '' : 'hidden' }}">
                <div class="mt-6 rounded-2xl border border-[#C9D8D0] bg-[#F3F7F5] p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="font-serif text-xl font-semibold text-[#2B4C3F]">Midtrans Online</h3>
                            <p class="text-sm text-[#5C6E65] mt-1">
                                QRIS, Virtual Account, e-wallet, dan metode online lain dalam satu popup.
                            </p>
                        </div>
                        <button type="button" id="midtrans-pay-button"
                            class="inline-flex h-12 items-center justify-center rounded-xl bg-[#B7791F] px-5 text-sm font-semibold text-white transition-all hover:bg-[#975A16] disabled:cursor-not-allowed disabled:opacity-60">
                            Bayar Sekarang
                        </button>
                    </div>
                    <p id="midtrans-payment-message" class="mt-3 hidden text-xs leading-relaxed"></p>
                </div>
            </div>

            @if (! $isMidtransLocked)
            <div data-payment-panel="manual" class="{{ $selectedPaymentPanel === 'manual' ? '' : 'hidden' }}">
                <form action="{{ route('user.pembayaran.store', $pemesanan->pemesanan_id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 rounded-2xl border border-[#E6E4DD] bg-[#FAF9F6] p-5">
                    @csrf

                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                        <div>
                            <h3 class="font-serif text-xl font-semibold text-[#2B4C3F]">Transfer Manual</h3>
                            <p class="text-sm text-[#5C6E65] mt-1">
                                Bukti pembayaran akan diverifikasi admin.
                            </p>
                        </div>
                        <span class="inline-flex h-8 items-center self-start rounded-full bg-[#FFF8E8] px-3 text-[11px] font-bold uppercase tracking-wider text-[#8A5A10]">
                            Verifikasi Admin
                        </span>
                    </div>

                    <div>
                        <label for="metode_pembayaran" class="block text-sm font-semibold text-[#2C3E35] mb-2">Metode Manual</label>
                        <select name="metode_pembayaran" id="metode_pembayaran"
                            class="w-full bg-white text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
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
                            class="w-full bg-white text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                        @error('jumlah_bayar')
                            <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bukti_pembayaran" class="block text-sm font-semibold text-[#2C3E35] mb-2">Bukti Pembayaran</label>
                        <label for="bukti_pembayaran"
                            class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-[#C9D8D0] bg-white px-6 py-8 text-center transition-all hover:border-[#2B4C3F] hover:bg-[#F3F7F5]">
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
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    @if (config('midtrans.client_key'))
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('bukti_pembayaran');
            const label = document.getElementById('bukti-file-label');
            const paymentMethodLockNotice = document.getElementById('payment-method-lock-notice');
            const paymentMethodSwitcher = document.getElementById('payment-method-switcher');
            const tabs = document.querySelectorAll('[data-payment-tab]');
            const panels = document.querySelectorAll('[data-payment-panel]');
            const midtransButton = document.getElementById('midtrans-pay-button');
            const midtransMessage = document.getElementById('midtrans-payment-message');
            const historyUrl = @json(route('user.pesanan.index'));
            const statusUrl = @json(route('user.pembayaran.midtrans.status', $pemesanan->pemesanan_id));

            const setPaymentPanel = function (target) {
                tabs.forEach(function (tab) {
                    const active = tab.dataset.paymentTab === target;
                    tab.className = active
                        ? 'payment-tab h-12 rounded-lg px-3 text-sm font-semibold transition-all bg-[#2B4C3F] text-white shadow-sm'
                        : 'payment-tab h-12 rounded-lg px-3 text-sm font-semibold transition-all text-[#5C6E65] hover:bg-white';
                });

                panels.forEach(function (panel) {
                    panel.classList.toggle('hidden', panel.dataset.paymentPanel !== target);
                });
            };

            const lockPaymentToMidtrans = function () {
                setPaymentPanel('midtrans');
                paymentMethodLockNotice?.classList.remove('hidden');
                paymentMethodSwitcher?.classList.add('hidden');
            };

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    setPaymentPanel(tab.dataset.paymentTab);
                });
            });

            if (midtransButton && midtransMessage) {
                const showMidtransMessage = function (message, isError = false) {
                    midtransMessage.textContent = message;
                    midtransMessage.className = isError
                        ? 'mt-3 text-xs leading-relaxed text-[#9B1C1C]'
                        : 'mt-3 text-xs leading-relaxed text-[#2B4C3F]';
                };

                const syncStatusThenRedirect = async function (message) {
                    showMidtransMessage(message);

                    try {
                        await fetch(statusUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });
                    } finally {
                        window.location.href = historyUrl;
                    }
                };

                midtransButton.addEventListener('click', async function () {
                    if (!window.snap) {
                        showMidtransMessage('Client Key Midtrans belum aktif. Isi MIDTRANS_CLIENT_KEY di file .env lalu refresh halaman.', true);
                        return;
                    }

                    midtransButton.disabled = true;
                    showMidtransMessage('Menyiapkan pembayaran Midtrans...');

                    try {
                        const response = await fetch(@json(route('user.pembayaran.midtrans.token', $pemesanan->pemesanan_id)), {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });
                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal membuat token pembayaran Midtrans.');
                        }

                        lockPaymentToMidtrans();

                        window.snap.pay(data.snap_token, {
                            onSuccess: function () {
                                syncStatusThenRedirect('Pembayaran berhasil. Menyinkronkan status Midtrans...');
                            },
                            onPending: function () {
                                syncStatusThenRedirect('Pembayaran dibuat. Menyinkronkan status Midtrans...');
                            },
                            onError: function () {
                                showMidtransMessage('Pembayaran Midtrans gagal. Coba ulangi pembayaran Midtrans.', true);
                                midtransButton.disabled = false;
                            },
                            onClose: function () {
                                showMidtransMessage('Popup Midtrans ditutup. Klik tombol lagi untuk melanjutkan pembayaran.');
                                midtransButton.disabled = false;
                            },
                        });
                    } catch (error) {
                        showMidtransMessage(error.message, true);
                        midtransButton.disabled = false;
                    }
                });
            }

            if (!input || !label) return;

            input.addEventListener('change', function () {
                const file = input.files && input.files[0];
                label.textContent = file ? file.name : 'Pilih bukti pembayaran';
            });
        });
    </script>
@endsection
