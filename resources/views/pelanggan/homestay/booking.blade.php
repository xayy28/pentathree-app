@extends('layouts.user')

@section('title', 'Booking Homestay')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-[#F8F7F4]">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E6E4DD] p-6 sm:p-8 shadow-sm">
                @include('components.back-link', ['href' => route('user.homestay'), 'label' => 'Kembali ke Homestay'])
                <h2 class="font-serif text-3xl text-[#2B4C3F] font-semibold tracking-widest uppercase mt-4">
                    Booking Homestay
                </h2>
                <p class="text-sm text-[#5C6E65] mt-2">
                    Pilih tanggal menginap untuk {{ $homestay->nama_homestay }}.
                </p>

                <div class="mt-6 rounded-2xl border border-[#E6E4DD] bg-[#FAF9F6] p-4 sm:p-5">
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-[#2B4C3F]">Kalender Ketersediaan</h3>
                            <p class="text-xs text-[#8A9C91] mt-1">Tanggal merah sudah terisi untuk kamar ini.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="calendar_prev" class="h-9 w-9 rounded-lg border border-[#E6E4DD] bg-white text-[#2C3E35] text-sm font-semibold hover:border-[#2B4C3F]" aria-label="Bulan sebelumnya">
                                &lt;
                            </button>
                            <button type="button" id="calendar_next" class="h-9 w-9 rounded-lg border border-[#E6E4DD] bg-white text-[#2C3E35] text-sm font-semibold hover:border-[#2B4C3F]" aria-label="Bulan berikutnya">
                                &gt;
                            </button>
                        </div>
                    </div>

                    <div id="calendar_title" class="text-center text-sm font-semibold text-[#2C3E35] mb-3"></div>
                    <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-semibold uppercase tracking-wider text-[#8A9C91] mb-2">
                        <span>Min</span>
                        <span>Sen</span>
                        <span>Sel</span>
                        <span>Rab</span>
                        <span>Kam</span>
                        <span>Jum</span>
                        <span>Sab</span>
                    </div>
                    <div id="availability_calendar" class="grid grid-cols-7 gap-1"></div>
                    <div class="mt-4 flex flex-wrap gap-3 text-xs text-[#5C6E65]">
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-white border border-[#E6E4DD]"></span>Tersedia</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-[#F9D6D5] border border-[#E65F5F]"></span>Terisi</span>
                        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-[#DDEBE4] border border-[#2B4C3F]"></span>Dipilih</span>
                    </div>
                </div>

                <form id="homestay_booking_form" action="{{ route('user.homestay.booking.store', $homestay->homestay_id) }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="check_in" class="block text-sm font-semibold text-[#2C3E35] mb-2">Check-in</label>
                            <input type="date" name="check_in" id="check_in" min="{{ now()->toDateString() }}" value="{{ old('check_in') }}" required
                                class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                            @error('check_in')
                                <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="check_out" class="block text-sm font-semibold text-[#2C3E35] mb-2">Check-out</label>
                            <input type="date" name="check_out" id="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out') }}" required
                                class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                            @error('check_out')
                                <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p id="date_availability_error" class="hidden text-xs text-[#E65F5F] -mt-2"></p>

                    <div>
                        <label for="jumlah_tamu" class="block text-sm font-semibold text-[#2C3E35] mb-2">Jumlah Tamu</label>
                        <input type="number" name="jumlah_tamu" id="jumlah_tamu" min="1" max="{{ $homestay->kapasitas }}" value="{{ old('jumlah_tamu', 1) }}" required
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none">
                        <p class="text-xs text-[#8A9C91] mt-2">Kapasitas maksimal {{ $homestay->kapasitas }} tamu.</p>
                        @error('jumlah_tamu')
                            <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-[#2C3E35] mb-2">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="4"
                            class="w-full bg-[#FAF9F6] text-[#2C3E35] border border-[#E6E4DD] rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#2B4C3F] focus:outline-none"
                            placeholder="Opsional, misalnya jam kedatangan atau permintaan khusus.">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-xs text-[#E65F5F] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-ui-button type="submit" id="booking_submit" variant="primary" size="lg" block>
                        Buat Booking
                    </x-ui-button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-6 shadow-sm space-y-5">
                <div class="aspect-[4/3] overflow-hidden rounded-xl bg-[#EAF2EE]">
                    @if ($homestay->foto)
                        <img src="{{ asset($homestay->foto) }}" alt="{{ $homestay->nama_homestay }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-[#8A9C91]">Homestay</div>
                    @endif
                </div>
                <div>
                    <h3 class="font-serif text-xl font-semibold text-[#2C3E35]">{{ $homestay->nama_homestay }}</h3>
                    <p class="text-xs text-[#8A9C91] mt-1">{{ $homestay->kategori->nama_kategori ?? 'Standard' }} - {{ $homestay->kapasitas }} tamu</p>
                </div>
                <div class="border-t border-[#F2F0EA] pt-4 flex justify-between gap-4">
                    <span class="text-sm text-[#8A9C91]">Harga per malam</span>
                    <span class="font-bold text-[#2B4C3F]">Rp {{ number_format($homestay->harga_permalam, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookedDates = new Set(@json($bookedDates));
            const monthFormatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
            const todayValue = '{{ now()->toDateString() }}';
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const form = document.getElementById('homestay_booking_form');
            const submitButton = document.getElementById('booking_submit');
            const calendar = document.getElementById('availability_calendar');
            const calendarTitle = document.getElementById('calendar_title');
            const errorText = document.getElementById('date_availability_error');
            let activeMonth = parseDate(checkInInput.value || todayValue);
            activeMonth = new Date(activeMonth.getFullYear(), activeMonth.getMonth(), 1);

            function parseDate(value) {
                const [year, month, day] = value.split('-').map(Number);

                return new Date(year, month - 1, day);
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }

            function addDays(date, days) {
                const nextDate = new Date(date);
                nextDate.setDate(nextDate.getDate() + days);

                return nextDate;
            }

            function isPast(dateValue) {
                return dateValue < todayValue;
            }

            function rangeHasBookedDate(startValue, endValue) {
                if (!startValue || !endValue || endValue <= startValue) {
                    return false;
                }

                let date = parseDate(startValue);
                const endDate = parseDate(endValue);

                while (date < endDate) {
                    if (bookedDates.has(formatDate(date))) {
                        return true;
                    }

                    date = addDays(date, 1);
                }

                return false;
            }

            function setError(message) {
                errorText.textContent = message;
                errorText.classList.toggle('hidden', !message);
                checkInInput.setCustomValidity(message);
                checkOutInput.setCustomValidity(message);
                submitButton.disabled = Boolean(message);
            }

            function validateDates() {
                checkInInput.setCustomValidity('');
                checkOutInput.setCustomValidity('');

                if (!checkInInput.value || !checkOutInput.value) {
                    setError('');
                    renderCalendar();
                    return true;
                }

                if (checkOutInput.value <= checkInInput.value) {
                    setError('Tanggal check-out harus setelah tanggal check-in.');
                    renderCalendar();
                    return false;
                }

                if (rangeHasBookedDate(checkInInput.value, checkOutInput.value)) {
                    setError('Rentang tanggal yang dipilih menyentuh tanggal yang sudah terisi.');
                    renderCalendar();
                    return false;
                }

                setError('');
                renderCalendar();
                return true;
            }

            function setCheckoutMinimum() {
                if (!checkInInput.value) {
                    checkOutInput.min = '{{ now()->addDay()->toDateString() }}';
                    return;
                }

                checkOutInput.min = formatDate(addDays(parseDate(checkInInput.value), 1));

                if (checkOutInput.value && checkOutInput.value <= checkInInput.value) {
                    checkOutInput.value = '';
                }
            }

            function isSelected(dateValue) {
                if (!checkInInput.value || !checkOutInput.value) {
                    return dateValue === checkInInput.value || dateValue === checkOutInput.value;
                }

                return dateValue >= checkInInput.value && dateValue <= checkOutInput.value;
            }

            function canUseAsCheckout(dateValue) {
                return checkInInput.value
                    && !checkOutInput.value
                    && dateValue > checkInInput.value
                    && !rangeHasBookedDate(checkInInput.value, dateValue);
            }

            function chooseDate(dateValue) {
                const checkoutCandidate = canUseAsCheckout(dateValue);

                if (isPast(dateValue) || (bookedDates.has(dateValue) && !checkoutCandidate)) {
                    return;
                }

                if (!checkInInput.value || (checkInInput.value && checkOutInput.value) || dateValue <= checkInInput.value) {
                    checkInInput.value = dateValue;
                    checkOutInput.value = '';
                } else {
                    checkOutInput.value = dateValue;
                }

                setCheckoutMinimum();
                validateDates();
            }

            function renderCalendar() {
                const year = activeMonth.getFullYear();
                const month = activeMonth.getMonth();
                const firstDay = new Date(year, month, 1);
                const totalDays = new Date(year, month + 1, 0).getDate();
                const offset = firstDay.getDay();
                calendarTitle.textContent = monthFormatter.format(activeMonth);
                calendar.innerHTML = '';

                for (let i = 0; i < offset; i++) {
                    const spacer = document.createElement('div');
                    spacer.className = 'aspect-square rounded-lg';
                    calendar.appendChild(spacer);
                }

                for (let day = 1; day <= totalDays; day++) {
                    const date = new Date(year, month, day);
                    const dateValue = formatDate(date);
                    const button = document.createElement('button');
                    const unavailable = bookedDates.has(dateValue);
                    const checkoutCandidate = unavailable && canUseAsCheckout(dateValue);
                    const disabled = isPast(dateValue) || (unavailable && !checkoutCandidate);
                    const selected = isSelected(dateValue);

                    button.type = 'button';
                    button.textContent = day;
                    button.dataset.date = dateValue;
                    button.setAttribute('aria-label', dateValue);
                    button.disabled = disabled;
                    button.className = 'aspect-square rounded-lg border text-xs sm:text-sm font-semibold transition-colors';

                    if (selected) {
                        button.className += ' bg-[#DDEBE4] border-[#2B4C3F] text-[#1E362C]';
                    } else if (unavailable && checkoutCandidate) {
                        button.className += ' bg-[#FFF7ED] border-[#E65F5F] text-[#8A2E2E] hover:bg-[#FDEAD7]';
                    } else if (unavailable) {
                        button.className += ' bg-[#F9D6D5] border-[#E65F5F] text-[#8A2E2E] cursor-not-allowed';
                    } else if (isPast(dateValue)) {
                        button.className += ' bg-[#F2F0EA] border-[#E6E4DD] text-[#B4B0A6] cursor-not-allowed';
                    } else {
                        button.className += ' bg-white border-[#E6E4DD] text-[#2C3E35] hover:border-[#2B4C3F] hover:bg-[#F4F8F6]';
                    }

                    calendar.appendChild(button);
                }
            }

            calendar.addEventListener('click', (event) => {
                const button = event.target.closest('button[data-date]');

                if (!button || button.disabled) {
                    return;
                }

                chooseDate(button.dataset.date);
            });

            document.getElementById('calendar_prev').addEventListener('click', () => {
                activeMonth = new Date(activeMonth.getFullYear(), activeMonth.getMonth() - 1, 1);
                renderCalendar();
            });

            document.getElementById('calendar_next').addEventListener('click', () => {
                activeMonth = new Date(activeMonth.getFullYear(), activeMonth.getMonth() + 1, 1);
                renderCalendar();
            });

            checkInInput.addEventListener('change', () => {
                if (checkInInput.value) {
                    activeMonth = new Date(parseDate(checkInInput.value).getFullYear(), parseDate(checkInInput.value).getMonth(), 1);
                }

                setCheckoutMinimum();
                validateDates();
            });

            checkOutInput.addEventListener('change', validateDates);

            form.addEventListener('submit', (event) => {
                if (!validateDates()) {
                    event.preventDefault();
                }
            });

            setCheckoutMinimum();
            validateDates();
            renderCalendar();
        });
    </script>
@endpush