<footer class="mt-16 bg-gradient-to-b from-[#1E362C] to-[#152720] text-[#FAF9F6] rounded-t-[2.5rem] shadow-2xl relative overflow-hidden border-t border-[#3B5D50]/30">
    <!-- Subtle Background Glow -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#EAF2EE]/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-[#FAF9F6]/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 pt-16 pb-8">
        <!-- 4-Column Layout Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
            
            <!-- Column 1: Logo & Deskripsi -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Natasha Homestay Logo"
                        class="h-12 w-12 rounded-full object-cover border-2 border-[#A7C5B5]/40 shadow-md">
                    <div class="flex flex-col">
                        <span class="font-serif text-lg font-bold tracking-wider text-white uppercase leading-none">
                            Natasha
                        </span>
                        <span class="text-xs text-[#A7C5B5] tracking-widest uppercase">
                            Homestay
                        </span>
                    </div>
                </div>
                
                <p class="text-xs text-[#A7C5B5] leading-relaxed">
                    Menghadirkan kehangatan dan kenyamanan menginap terbaik di tengah keindahan megah tebing alam Lembah Harau. Tempat peristirahatan yang damai dan bersahabat untuk petualangan tak terlupakan Anda.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center gap-3 pt-2">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/natashahomestay?igsh=anJqZjY4YTAzaWIy" target="_blank" rel="noopener noreferrer" 
                        class="w-9 h-9 rounded-full bg-[#3B5D50]/40 flex items-center justify-center text-[#A7C5B5] hover:bg-gradient-to-tr hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 hover:text-white hover:scale-115 hover:shadow-lg transition-all duration-300" 
                        aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    <!-- Facebook -->
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                        class="w-9 h-9 rounded-full bg-[#3B5D50]/40 flex items-center justify-center text-[#A7C5B5] hover:bg-[#1877F2] hover:text-white hover:scale-115 hover:shadow-lg transition-all duration-300" 
                        aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8H7v3h2v9h4v-9h3.61L17 8h-4V6.5c0-.9.23-1.38 1-1.38H16V1H13c-3.75 0-4 2.85-4 5v2z"/>
                        </svg>
                    </a>
                    <!-- WhatsApp -->
                    <a href="https://wa.me/6282384703440" target="_blank" rel="noopener noreferrer" 
                        class="w-9 h-9 rounded-full bg-[#3B5D50]/40 flex items-center justify-center text-[#A7C5B5] hover:bg-[#25D366] hover:text-white hover:scale-115 hover:shadow-lg transition-all duration-300" 
                        aria-label="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.483 1.451 5.407 1.452 5.518 0 10.007-4.492 10.01-10.013.001-2.673-1.04-5.186-2.93-7.078C17.24 1.621 14.73 1.579 12.012 1.579c-5.524 0-10.014 4.496-10.017 10.02-.001 1.996.523 3.947 1.52 5.679l-.995 3.637 3.729-.978zm14.33-6.046c-.29-.145-1.716-.847-1.982-.943-.266-.097-.46-.145-.653.146-.193.29-.747.943-.917 1.137-.17.194-.34.218-.63.073-.29-.145-1.225-.452-2.333-1.442-.862-.77-1.444-1.72-1.613-2.01-.17-.29-.018-.448.127-.592.13-.13.29-.338.435-.507.145-.17.193-.29.29-.483.097-.193.048-.363-.024-.508-.073-.145-.653-1.573-.895-2.153-.236-.569-.475-.49-.653-.5H8.75c-.193 0-.507.072-.773.362-.266.29-1.014.99-1.014 2.415 0 1.425 1.038 2.801 1.183 2.995.145.193 2.043 3.12 4.949 4.373.692.298 1.232.476 1.653.61.696.222 1.33.19 1.83.116.558-.08 1.716-.701 1.958-1.377.242-.676.242-1.256.17-1.376-.073-.12-.266-.194-.555-.34z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Column 2: Navigasi -->
            <div class="space-y-6 lg:pl-6">
                <h4 class="font-serif text-base font-semibold text-white tracking-wide border-b border-[#3B5D50]/50 pb-2.5 inline-block">
                    Navigasi
                </h4>
                <nav class="flex flex-col space-y-3.5">
                    @php
                        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
                        $homeRoute = auth()->check() ? ($isAdmin ? route('admin.dashboard') : route('dashboard')) : '#';
                        $homestayRoute = auth()->check() ? ($isAdmin ? route('admin.homestay') : route('user.homestay')) : '#';
                        $souvenirRoute = auth()->check() ? ($isAdmin ? route('admin.souvenir') : route('user.souvenir')) : '#';
                        $reservasiRoute = auth()->check() ? ($isAdmin ? route('admin.reservasi') : route('user.reservasi')) : '#';
                    @endphp
                    <a href="{{ $homeRoute }}" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91] group-hover:text-white transition-colors">✦</span> Beranda
                    </a>
                    <a href="{{ $homestayRoute }}" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91] group-hover:text-white transition-colors">✦</span> Homestay
                    </a>
                    <a href="{{ $souvenirRoute }}" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91] group-hover:text-white transition-colors">✦</span> Souvenir
                    </a>
                    <a href="{{ $reservasiRoute }}" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91] group-hover:text-white transition-colors">✦</span> Riwayat Pesanan
                    </a>
                </nav>
            </div>

            <!-- Column 3: Bantuan -->
            <div class="space-y-6 lg:pl-2">
                <h4 class="font-serif text-base font-semibold text-white tracking-wide border-b border-[#3B5D50]/50 pb-2.5 inline-block">
                    Bantuan
                </h4>
                <nav class="flex flex-col space-y-3.5">
                    <a href="#faq" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91]">✦</span> FAQ
                    </a>
                    <a href="#cara-pemesanan" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91]">✦</span> Cara Pemesanan
                    </a>
                    <a href="#kebijakan-privasi" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91]">✦</span> Kebijakan Privasi
                    </a>
                    <a href="#syarat-ketentuan" 
                        class="text-xs text-[#A7C5B5] hover:text-white hover:translate-x-1.5 transition-all duration-300 flex items-center gap-2">
                        <span class="text-[#8A9C91]">✦</span> Syarat & Ketentuan
                    </a>
                </nav>
            </div>

            <!-- Column 4: Kontak & Maps -->
            <div class="space-y-4">
                <h4 class="font-serif text-base font-semibold text-white tracking-wide border-b border-[#3B5D50]/50 pb-2.5 inline-block">
                    Kontak & Lokasi
                </h4>
                
                <!-- Google Maps Card Container -->
                <div class="rounded-2xl border border-[#3B5D50]/50 shadow-lg overflow-hidden bg-[#1E362C]/40 p-1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7735398950666!2d100.6619987!3d-0.1139392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2aad004df0d94b%3A0xe9ed9dd51c819334!2sHomestay%20Natasha!5e0!3m2!1sid!2sid!4v1718392500000!5m2!1sid!2sid" 
                        width="100%" 
                        height="110" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        class="rounded-xl filter brightness-95 contrast-105"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <!-- Address Details -->
                <div class="text-[11px] text-[#A7C5B5] leading-relaxed flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-white shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Lembah Harau, Kab. Lima Puluh Kota, Sumatera Barat</span>
                </div>

                <!-- Action Button Google Maps -->
                <div>
                    <a href="https://maps.app.goo.gl/eJLijBrJjBnMqDmA9" target="_blank" rel="noopener noreferrer" 
                        class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-white bg-[#3B5D50] hover:bg-[#A7C5B5] hover:text-[#1E362C] px-3 py-1.5 rounded-lg border border-[#A7C5B5]/20 hover:border-transparent transition-all duration-300 group shadow-sm cursor-pointer">
                        <span>Lihat di Google Maps</span>
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

                <!-- Direct Contacts -->
                <div class="space-y-2 pt-2 border-t border-[#3B5D50]/30">
                    <a href="mailto:natashahomestay.harau@gmail.com" 
                        class="flex items-center gap-2 text-[11px] text-[#A7C5B5] hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="truncate">natashahomestay.harau@gmail.com</span>
                    </a>
                    <a href="https://wa.me/6282384703440" target="_blank" rel="noopener noreferrer" 
                        class="flex items-center gap-2 text-[11px] text-[#A7C5B5] hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+62 823-8470-3440</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Divider Line -->
        <div class="border-t border-[#3B5D50]/40 mt-12 pt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-[11px] text-[#A7C5B5] text-center sm:text-left">
                    &copy; 2026 PentaThree. All Rights Reserved.
                </p>
                <div class="flex items-center gap-4 text-[10px] text-[#8A9C91]">
                    <a href="#kebijakan-privasi" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#syarat-ketentuan" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>

    </div>
</footer>
