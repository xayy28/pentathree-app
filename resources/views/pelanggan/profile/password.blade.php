@extends('layouts.user')

@section('title', 'Ubah Password')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-[32px] border border-[#E6E4DD] shadow-sm p-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-serif font-semibold text-[#2B4C3F]">Ubah Password</h1>
                    <p class="text-sm text-[#5C6E65] mt-1">Perbarui password Anda untuk menjaga keamanan akun.</p>
                </div>
                @include('components.back-link', ['href' => route('profile.show'), 'label' => 'Kembali'])
            </div>

            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password"
                        class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Password Saat
                        Ini</label>
                    <input type="password" name="current_password" id="current_password"
                        value="{{ old('current_password') }}" required
                        class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                    @error('current_password')
                        <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Password
                        Baru</label>
                    <input type="password" name="password" id="password" value="{{ old('password') }}" required
                        class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                    @error('password')
                        <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Konfirmasi Password
                        Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        value="{{ old('password_confirmation') }}" required
                        class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                </div>

                <x-ui-button type="submit" variant="primary" block>
                    Perbarui Password
                </x-ui-button>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 mx-4">
            <h3 id="confirm-modal-title" class="text-lg font-semibold text-[#2B4C3F]">Konfirmasi</h3>
            <p id="confirm-modal-message" class="text-sm text-[#5C6E65] mt-2">Apakah Anda yakin ingin mengganti password?
            </p>
            <div class="mt-6 flex justify-end gap-3">
                <x-ui-button type="button" id="confirm-cancel" variant="muted" size="sm">
                    Batal
                </x-ui-button>
                <x-ui-button type="button" id="confirm-ok" variant="primary" size="sm">
                    Oke
                </x-ui-button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.querySelector('form[action="{{ route('profile.password.update') }}"]');
            if (!form) return;

            const modal = document.getElementById('confirm-modal');
            const btnOk = document.getElementById('confirm-ok');
            const btnCancel = document.getElementById('confirm-cancel');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            btnCancel.addEventListener('click', function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });

            btnOk.addEventListener('click', function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                form.submit();
            });
        })();
    </script>

@endsection
