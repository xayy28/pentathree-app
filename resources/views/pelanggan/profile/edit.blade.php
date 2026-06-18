@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-[32px] border border-[#E6E4DD] shadow-sm p-8">
            <div class="flex items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-serif font-semibold text-[#2B4C3F]">Edit Profil</h1>
                    <p class="text-sm text-[#5C6E65] mt-1">Perbarui data akun dan informasi kontak Anda.</p>
                </div>
                <a href="{{ route('profile.show') }}"
                    class="inline-flex items-center justify-center rounded-full border border-[#D5D3C7] px-4 py-2 text-sm font-semibold text-[#2C3E35] hover:bg-[#F8F7F4] transition">Kembali</a>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="nama"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                        @error('nama')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                        @error('email')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="no_hp"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Nomor
                            HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20">
                        @error('no_hp')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="alamat"
                            class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="w-full rounded-3xl border border-[#D5D3C7] bg-[#FAF9F6] px-4 py-3 text-sm text-[#2C3E35] focus:border-[#2B4C3F] focus:outline-none focus:ring-1 focus:ring-[#2B4C3F]/20 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[#5C6E65] mb-2">Foto
                            Profil</label>

                        @if ($user->foto_profil)
                            <div id="existing-image-container" class="mb-4">
                                <p class="text-[0.7rem] text-[#8A9C91] mb-2">Foto Saat Ini:</p>
                                <div class="w-24 h-24 rounded-full overflow-hidden border border-[#E6E4DD] shadow-sm">
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif

                        <label for="foto_profil" id="upload-zone"
                            class="flex flex-col items-center justify-center gap-3 rounded-3xl border-2 border-dashed border-[#D5D3C7] bg-[#FAF9F6] px-5 py-6 text-center cursor-pointer transition-all"
                            onmouseover="this.style.borderColor='#2B4C3F'; this.style.background='#EEF7F2';"
                            onmouseout="this.style.borderColor='#D5D3C7'; this.style.background='#FAF9F6';">
                            <div class="w-12 h-12 rounded-2xl bg-[#EAF2EE] flex items-center justify-center">
                                <svg width="20" height="20" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold text-[#2C3E35]">Klik atau seret untuk pilih
                                    foto</span>
                                <span class="block text-xs text-[#8A9C91]">PNG, JPG, JPEG, WEBP hingga 2MB</span>
                            </div>
                            <input type="file" name="foto_profil" id="foto_profil" class="hidden"
                                accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewProfileImage(event)">
                        </label>

                        <div id="file-name-display"
                            class="hidden mt-3 flex items-center gap-2 rounded-2xl border border-[#B8DEC8] bg-[#EAF2EE] px-3 py-2 text-sm text-[#2B4C3F]">
                            <svg width="14" height="14" fill="none" stroke="#2B4C3F" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span id="file-name-text"></span>
                        </div>

                        <div id="image-preview-container" class="hidden mt-4">
                            <p class="text-[0.7rem] text-[#8A9C91] mb-2">Pratinjau Foto Baru:</p>
                            <div class="w-24 h-24 rounded-full overflow-hidden border border-[#E6E4DD] shadow-sm">
                                <img id="image-preview" src="#" alt="Pratinjau Foto"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        @error('foto_profil')
                            <p class="mt-2 text-xs text-[#9B1C1C]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-[#2B4C3F] px-6 py-3 text-sm font-semibold text-white hover:bg-[#25382f] transition">Simpan
                    Perubahan Profil</button>
            </form>
        </div>

        <script>
            function previewProfileImage(event) {
                const input = event.target;
                const container = document.getElementById('image-preview-container');
                const preview = document.getElementById('image-preview');
                const existing = document.getElementById('existing-image-container');
                const fileNameDisplay = document.getElementById('file-name-display');
                const fileNameText = document.getElementById('file-name-text');
                const uploadZone = document.getElementById('upload-zone');

                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        container.classList.remove('hidden');
                        if (fileNameDisplay) {
                            fileNameText.textContent = file.name;
                            fileNameDisplay.classList.remove('hidden');
                        }
                        if (uploadZone) {
                            uploadZone.style.borderColor = '#2B4C3F';
                            uploadZone.style.background = '#EEF7F2';
                        }
                        if (existing) existing.style.opacity = '0.5';
                    }

                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    if (container) container.classList.add('hidden');
                    if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
                    if (uploadZone) {
                        uploadZone.style.borderColor = '#D5D3C7';
                        uploadZone.style.background = '#FAF9F6';
                    }
                    if (existing) existing.style.opacity = '1';
                }
            }
        </script>

        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 mx-4">
                <h3 id="confirm-modal-title" class="text-lg font-semibold text-[#2B4C3F]">Konfirmasi</h3>
                <p id="confirm-modal-message" class="text-sm text-[#5C6E65] mt-2">Apakah Anda yakin ingin menyimpan
                    perubahan profil?</p>
                <div class="mt-6 flex justify-end gap-3">
                    <button id="confirm-cancel"
                        class="px-4 py-2 rounded-full border border-[#D5D3C7] bg-white text-sm text-[#2C3E35] hover:bg-[#F8F7F4]">Batal</button>
                    <button id="confirm-ok" class="px-4 py-2 rounded-full bg-[#2B4C3F] text-white text-sm">Oke</button>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const form = document.querySelector('form[action="{{ route('profile.update') }}"]');
                if (!form) return;

                const modal = document.getElementById('confirm-modal');
                const title = document.getElementById('confirm-modal-title');
                const message = document.getElementById('confirm-modal-message');
                const btnOk = document.getElementById('confirm-ok');
                const btnCancel = document.getElementById('confirm-cancel');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    title.textContent = 'Konfirmasi Perubahan Profil';
                    message.textContent = 'Apakah Anda yakin ingin menyimpan perubahan profil?';
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
    </div>
    </div>
@endsection
