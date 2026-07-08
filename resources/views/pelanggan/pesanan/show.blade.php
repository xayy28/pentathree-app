@extends('layouts.user')

@section('title', 'Detail Pesanan')

@section('content')
    @php
        $statusLabels = $pemesanan->jenis_pemesanan === \App\Models\Pemesanan::JENIS_HOMESTAY
            ? \App\Models\Pemesanan::homestayStatusLabels()
            : \App\Models\Pemesanan::souvenirStatusLabels();
        $statusLabel = $statusLabels[$pemesanan->status_pemesanan] ?? ucwords(str_replace('_', ' ', $pemesanan->status_pemesanan));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                @include('components.back-link', ['href' => route('user.pesanan.index'), 'label' => 'Kembali ke Riwayat'])
                <h2 class="font-serif text-3xl sm:text-4xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-3">
                    Detail Pesanan
                </h2>
            </div>
            <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-[#EAF2EE] text-[#2B4C3F] self-start sm:self-auto">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm">
                <div class="border-b border-[#F2F0EA] pb-4 mb-5">
                    <div class="font-mono text-sm font-bold text-[#2B4C3F]">{{ $pemesanan->kode_pemesanan }}</div>
                    <div class="text-xs text-[#8A9C91] mt-1">
                        Dibuat pada {{ $pemesanan->tanggal_pemesanan->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($pemesanan->detailPemesanans as $detail)
                        <div class="flex items-center gap-4 border-b border-[#F2F0EA] pb-4 last:border-0 last:pb-0">
                            <div class="w-16 h-16 bg-[#EAF2EE]/50 flex-shrink-0 border border-[#E6E4DD]/40 rounded-lg overflow-hidden">
                                @if ($detail->souvenir?->foto)
                                    <img src="{{ asset($detail->souvenir->foto) }}" alt="{{ $detail->nama_item }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-[#8A9C91] bg-[#FAF9F6]">Item</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-[#2C3E35] truncate">{{ $detail->nama_item }}</h3>
                                <p class="text-xs text-[#8A9C91] mt-1">
                                    @if ($detail->homestay_id)
                                        {{ $detail->jumlah_malam }} malam · {{ $detail->check_in->format('d M Y') }} - {{ $detail->check_out->format('d M Y') }}
                                    @else
                                        {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right font-semibold text-[#2B4C3F]">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($pemesanan->pembayaran?->status_pembayaran === \App\Models\Pembayaran::STATUS_TERVERIFIKASI)
                    <div class="mt-6 border-t border-[#F2F0EA] pt-6 space-y-4">
                        <div>
                            <h3 class="font-serif text-xl font-semibold text-[#2C3E35]">Ulasan Pesanan</h3>
                            <p class="text-xs text-[#8A9C91] mt-1">Beri rating setelah pembayaran pesanan terverifikasi.</p>
                        </div>

                        @foreach ($pemesanan->detailPemesanans as $detail)
                            @php $existingUlasan = $detail->ulasan; @endphp
                            <form action="{{ route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]) }}" method="POST"
                                class="rounded-xl border border-[#E6E4DD] bg-[#FAF9F6] p-4 space-y-4">
                                @csrf
                                @php $selectedRating = (int) old('rating', $existingUlasan?->rating); @endphp
                                <div class="flex flex-col gap-3">
                                    <div>
                                        <div class="text-sm font-semibold text-[#2C3E35]">{{ $detail->nama_item }}</div>
                                        @if ($existingUlasan)
                                            <div class="text-xs text-[#8A9C91] mt-1">Ulasan terakhir: {{ $existingUlasan->rating }} dari 5</div>
                                        @endif
                                    </div>

                                    <div class="rating-picker rounded-2xl border border-[#E6E4DD] bg-white px-4 py-3" data-rating-picker>
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="flex items-center gap-1" role="radiogroup" aria-label="Rating untuk {{ $detail->nama_item }}">
                                                @for ($value = 1; $value <= 5; $value++)
                                                    <input type="radio" id="rating-{{ $detail->detail_pemesanan_id }}-{{ $value }}" name="rating" value="{{ $value }}"
                                                        class="sr-only rating-input" @checked($selectedRating === $value) required>
                                                    <label for="rating-{{ $detail->detail_pemesanan_id }}-{{ $value }}"
                                                        class="rating-star cursor-pointer rounded-xl p-1.5 text-[#D8D5CC] transition-all duration-150 hover:bg-[#FFF8E8] focus-within:ring-2 focus-within:ring-[#F6B21A]"
                                                        data-rating="{{ $value }}" title="{{ $value }} dari 5">
                                                        <svg class="h-8 w-8 transition-transform duration-150" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.161c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.058 9.384c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.95-.69l1.292-3.957z" />
                                                        </svg>
                                                    </label>
                                                @endfor
                                            </div>
                                            <span class="rating-label text-xs font-bold text-[#8A9C91] whitespace-nowrap">
                                                {{ $selectedRating ? $selectedRating . ' dari 5' : 'Pilih rating' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <textarea name="komentar" rows="3" maxlength="1000"
                                    class="w-full rounded-xl border-[#E6E4DD] bg-white text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:ring-[#2B4C3F]"
                                    placeholder="Tulis pengalaman singkat Anda">{{ old('komentar', $existingUlasan?->komentar) }}</textarea>

                                @error('rating')
                                    <p class="text-xs text-[#B91C1C]">{{ $message }}</p>
                                @enderror
                                @error('komentar')
                                    <p class="text-xs text-[#B91C1C]">{{ $message }}</p>
                                @enderror

                                <x-ui-button type="submit" variant="primary">
                                    {{ $existingUlasan ? 'Perbarui Ulasan' : 'Simpan Ulasan' }}
                                </x-ui-button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <h3 class="font-serif text-xl font-semibold text-[#2C3E35] border-b border-[#F2F0EA] pb-4">
                    Ringkasan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Jenis</span>
                        <span class="font-semibold text-[#2C3E35] capitalize">{{ $pemesanan->jenis_pemesanan }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Pembayaran</span>
                        <span class="font-semibold text-[#2C3E35]">
                            {{ $pemesanan->pembayaran ? str_replace('_', ' ', $pemesanan->pembayaran->status_pembayaran) : 'belum dibayar' }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#8A9C91]">Jumlah Item</span>
                        <span class="font-semibold text-[#2C3E35]">{{ $pemesanan->detailPemesanans->sum('jumlah') }}</span>
                    </div>
                    <div class="flex justify-between gap-4 border-t border-[#F2F0EA] pt-4">
                        <span class="font-bold text-[#2C3E35]">Total</span>
                        <span class="font-bold text-[#E65F5F]">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if (! $pemesanan->pembayaran || $pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_DITOLAK)
                    <x-ui-button href="{{ route('user.pembayaran.create', $pemesanan->pemesanan_id) }}" variant="primary" block>
                        Bayar Sekarang
                    </x-ui-button>
                @elseif ($pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_PEMBAYARAN)
                    <div class="space-y-3">
                        <p class="text-[11px] leading-relaxed text-[#8A5A10] bg-[#FFF8E8] border border-[#F2D8A8] rounded-xl p-4">
                            Pembayaran Midtrans masih menunggu penyelesaian atau sinkronisasi status. Jika sudah membayar, cek status pembayaran.
                        </p>
                        @if ($pemesanan->pembayaran->metode_pembayaran === 'midtrans')
                            <x-ui-button href="{{ route('user.pembayaran.create', $pemesanan->pemesanan_id) }}" variant="primary" block>
                                Lanjutkan Pembayaran
                            </x-ui-button>
                            <x-ui-button type="button" id="midtrans-status-button" data-status-url="{{ route('user.pembayaran.midtrans.status', $pemesanan->pemesanan_id) }}" variant="secondary" block>
                                Cek Status Pembayaran
                            </x-ui-button>
                            <p id="midtrans-status-message" class="hidden text-[11px] leading-relaxed"></p>
                        @endif
                    </div>
                @elseif ($pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_VERIFIKASI)
                    <p class="text-[11px] leading-relaxed text-[#8A9C91] bg-[#FAF9F6] border border-[#E6E4DD] rounded-xl p-4">
                        Bukti pembayaran sudah dikirim dan sedang menunggu verifikasi admin.
                    </p>
                @elseif ($pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_TERVERIFIKASI)
                    <div class="space-y-3">
                        <p class="text-[11px] leading-relaxed text-[#2B4C3F] bg-[#EAF2EE] border border-[#A7C5B5] rounded-xl p-4">
                            @if ($pemesanan->jenis_pemesanan === \App\Models\Pemesanan::JENIS_HOMESTAY)
                                Pembayaran sudah terverifikasi. Booking sudah dikonfirmasi dan menunggu jadwal check-in.
                            @else
                                Pembayaran sudah terverifikasi. Status pesanan: {{ $statusLabel }}.
                            @endif
                        </p>
                        @if ($pemesanan->invoice)
                            <x-ui-button href="{{ route('user.invoices.show', $pemesanan->pemesanan_id) }}" variant="secondary" block>
                                Lihat Invoice
                            </x-ui-button>
                        @endif
                    </div>
                @endif

                @if ($pemesanan->pembayaran?->catatan_admin)
                    <p class="text-[11px] leading-relaxed text-[#9B1C1C] bg-[#FDF2F2] border border-[#F5C2C2] rounded-xl p-4">
                        Catatan admin: {{ $pemesanan->pembayaran->catatan_admin }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    @if (
        $pemesanan->pembayaran?->metode_pembayaran === 'midtrans' &&
            $pemesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU_PEMBAYARAN)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const statusButton = document.getElementById('midtrans-status-button');
                const statusMessage = document.getElementById('midtrans-status-message');

                if (!statusButton || !statusMessage) return;

                const showStatusMessage = function (message, isError = false) {
                    statusMessage.textContent = message;
                    statusMessage.className = isError
                        ? 'text-[11px] leading-relaxed text-[#9B1C1C]'
                        : 'text-[11px] leading-relaxed text-[#2B4C3F]';
                };

                statusButton.addEventListener('click', async function () {
                    statusButton.disabled = true;
                    showStatusMessage('Mengecek status pembayaran Midtrans...');

                    try {
                        const response = await fetch(statusButton.dataset.statusUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': @json(csrf_token()),
                            },
                        });
                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal mengecek status pembayaran Midtrans.');
                        }

                        showStatusMessage(data.message || 'Status pembayaran berhasil diperbarui.');

                        if (data.pembayaran_status !== @json(\App\Models\Pembayaran::STATUS_MENUNGGU_PEMBAYARAN)) {
                            window.location.reload();
                        }
                    } catch (error) {
                        showStatusMessage(error.message, true);
                    } finally {
                        statusButton.disabled = false;
                    }
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ratingLabels = {
                1: 'Sangat buruk',
                2: 'Kurang puas',
                3: 'Cukup',
                4: 'Puas',
                5: 'Sangat puas',
            };

            document.querySelectorAll('[data-rating-picker]').forEach(function (picker) {
                const inputs = Array.from(picker.querySelectorAll('.rating-input'));
                const stars = Array.from(picker.querySelectorAll('.rating-star'));
                const label = picker.querySelector('.rating-label');

                const selectedValue = function () {
                    const selected = inputs.find(function (input) {
                        return input.checked;
                    });

                    return selected ? Number(selected.value) : 0;
                };

                const paint = function (value) {
                    stars.forEach(function (star) {
                        const starValue = Number(star.dataset.rating);
                        const active = starValue <= value;

                        star.classList.toggle('text-[#F6B21A]', active);
                        star.classList.toggle('text-[#D8D5CC]', !active);
                        star.classList.toggle('scale-105', active);
                    });

                    if (label) {
                        label.textContent = value ? `${value} dari 5 - ${ratingLabels[value]}` : 'Pilih rating';
                        label.classList.toggle('text-[#B7791F]', value > 0);
                        label.classList.toggle('text-[#8A9C91]', value === 0);
                    }
                };

                stars.forEach(function (star) {
                    star.addEventListener('mouseenter', function () {
                        paint(Number(star.dataset.rating));
                    });
                    star.addEventListener('mouseleave', function () {
                        paint(selectedValue());
                    });
                });

                inputs.forEach(function (input) {
                    input.addEventListener('change', function () {
                        paint(selectedValue());
                    });
                });

                paint(selectedValue());
            });
        });
    </script>
@endsection
