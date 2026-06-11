@extends(auth()->user()->role === 'admin' ? 'layouts.app' : 'layouts.user')

@section('title', auth()->user()->role === 'admin' ? 'Kelola Souvenir' : 'Harau Local Crafts')

@section('content')
    <div class="space-y-8">

        @if(auth()->user()->role === 'admin')
            <!-- ADMIN INTERFACE -->
            <div class="bg-white rounded-2xl border border-[#E6E4DD] p-8 shadow-sm">
                <h1 class="text-3xl font-serif font-semibold text-[#2C3E35] mb-2">Kelola Souvenir</h1>
                <p class="text-sm text-[#5C6E65] leading-relaxed mb-6">
                    Halaman pengelolaan Souvenir sedang dalam pengembangan untuk Project Base Learning (PBL).
                </p>

                <div
                    class="p-6 bg-[#FAF9F6] border border-dashed border-[#D5D3C7] rounded-xl flex flex-col items-center justify-center text-center">
                    <span class="text-5xl mb-4">🏺</span>
                    <h3 class="text-lg font-semibold text-[#2C3E35] mb-1">Fitur Souvenir Belum Tersedia</h3>
                    <p class="text-xs text-[#8A9C91] max-w-sm">
                        Anda dapat menambahkan CRUD produk souvenir, form upload foto, pengaturan harga, dan manajemen stok di
                        sini.
                    </p>
                </div>
            </div>

        @else
            <!-- USER INTERFACE (Katalog E-commerce Premium Sesuai Mockup) -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16 bg-[#F8F7F4]">

                <!-- Section 1: Curated Collections Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-semibold tracking-[0.25em] text-[#8A9C91] uppercase block">
                        Curated Collections
                    </span>
                    <h1 class="font-serif text-4xl sm:text-5xl text-[#2B4C3F] font-semibold tracking-wide leading-tight">
                        Harau Local Crafts
                    </h1>
                    <p
                        class="text-[10px] sm:text-xs text-[#5C6E65] font-serif uppercase tracking-[0.15em] leading-relaxed max-w-xl mx-auto mt-3">
                        Discover the "space between things" through the hands of Harau Valley's finest artisans. Every piece
                        tells a story of deliberate living and ancient craftsmanship.
                    </p>
                </div>

                <!-- Section 2: Horizontal Category Tabs -->
                <div class="flex justify-center border-b border-[#E6E4DD] pb-4">
                    <div class="flex gap-8 sm:gap-12" id="craft-tabs">
                        <button data-filter="all"
                            class="text-xs font-semibold tracking-widest uppercase pb-3 border-b-2 border-[#2B4C3F] text-[#2B4C3F] transition-all active-tab-btn">
                            All Crafts
                        </button>
                        <button data-filter="ceramics"
                            class="text-xs font-medium tracking-widest uppercase pb-3 border-b-2 border-transparent text-[#8A9C91] hover:text-[#2B4C3F] transition-all">
                            Ceramics
                        </button>
                        <button data-filter="textiles"
                            class="text-xs font-medium tracking-widest uppercase pb-3 border-b-2 border-transparent text-[#8A9C91] hover:text-[#2B4C3F] transition-all">
                            Textiles
                        </button>
                        <button data-filter="carvings"
                            class="text-xs font-medium tracking-widest uppercase pb-3 border-b-2 border-transparent text-[#8A9C91] hover:text-[#2B4C3F] transition-all">
                            Carvings
                        </button>
                    </div>
                </div>

                <!-- Section 3: Premium Products Grid (Responsive & Airbnb Style) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 md:gap-10" id="souvenir-grid">

                    <!-- Item 1: Guci Tanah Liat Klasik -->
                    <div class="group flex flex-col justify-between craft-card" data-category="ceramics">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1612196808214-b8e1d6145a8c?auto=format&fit=crop&w=800&q=80"
                                    alt="Guci Tanah Liat Klasik"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Guci Tanah Liat Klasik</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 120.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                    <!-- Item 2: Syal Kain Tenun -->
                    <div class="group flex flex-col justify-between craft-card" data-category="textiles">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80"
                                    alt="Syal Kain Tenun"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Syal Kain Tenun</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 180.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                    <!-- Item 3: Piring Hias Keramik -->
                    <div class="group flex flex-col justify-between craft-card" data-category="ceramics">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=800&q=80"
                                    alt="Piring Hias Keramik"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Piring Hias Keramik</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 95.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                    <!-- Item 4: Pahat Kayu Harau -->
                    <div class="group flex flex-col justify-between craft-card" data-category="carvings">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1606293926075-69a00dbfde81?auto=format&fit=crop&w=800&q=80"
                                    alt="Pahat Kayu Harau"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Pahat Kayu Harau</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 250.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                    <!-- Item 5: Songket Minangkabau -->
                    <div class="group flex flex-col justify-between craft-card" data-category="textiles">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1531835551805-16d864c8d311?auto=format&fit=crop&w=800&q=80"
                                    alt="Songket Minangkabau"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Songket Minangkabau</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 450.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                    <!-- Item 6: Kotak Perhiasan Ukir -->
                    <div class="group flex flex-col justify-between craft-card" data-category="carvings">
                        <div class="space-y-4">
                            <div class="aspect-square overflow-hidden rounded-2xl relative bg-[#EAF2EE]/10">
                                <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80"
                                    alt="Kotak Perhiasan Ukir"
                                    class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <div class="px-1">
                                <h4 class="font-medium text-[#2C3E35] text-base leading-tight">Kotak Perhiasan Ukir</h4>
                            </div>
                        </div>
                        <div class="pt-3 px-1 flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#2B4C3F]">Rp 150.000</span>
                            <button
                                class="px-5 py-2 bg-[#1E1E1E] hover:bg-[#2B4C3F] text-white text-xs font-semibold rounded-lg transition-colors">
                                Checkout
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Section 4: Philosophy Banner Section (Bottom) -->
                <div
                    class="bg-[#12261E] rounded-[40px] py-16 px-6 sm:px-12 lg:px-20 text-white relative overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8">
                    <!-- Ambient green blur background -->
                    <div
                        class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-[#2B4C3F]/20 blur-3xl pointer-events-none">
                    </div>

                    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-16 items-center">

                        <!-- Left: Pottery artisan photo with overlapping white quote card -->
                        <div class="w-full lg:w-[48%] relative flex items-center justify-center">
                            <div class="w-full h-80 sm:h-96 rounded-3xl overflow-hidden shadow-lg bg-emerald-950/20">
                                <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80"
                                    alt="Artisan shaping clay" class="w-full h-full object-cover">
                            </div>

                            <!-- Overlay Quote Card -->
                            <div
                                class="absolute bottom-6 right-6 lg:-bottom-6 lg:-right-6 bg-white p-6 shadow-xl max-w-xs sm:max-w-sm rounded-2xl text-left border border-[#E6E4DD]/40">

                                <p class="font-serif text-[#2C3E35] text-xs sm:text-sm italic leading-relaxed">
                                    "Crafting is not just making; it's a conversation between the soul and the earth."
                                </p>
                                <p class="text-[9px] text-[#8A9C91] font-bold uppercase tracking-wider mt-3 block">
                                    — Ibu Kartini, Master Weaver
                                </p>
                            </div>
                        </div>

                        <!-- Right: Curated description -->
                        <div class="w-full lg:w-[52%] space-y-6 text-left">
                            <span class="text-xs font-semibold tracking-[0.25em] text-[#A7C5B5] uppercase block">
                                Our Philosophy
                            </span>
                            <h3 class="font-serif text-3xl sm:text-4xl text-white font-bold leading-tight">
                                Preserving the Aura of the Harau Valley
                            </h3>
                            <p class="text-sm text-white/80 leading-relaxed font-sans max-w-xl">
                                At Harau Souvenirs, we believe in the luxury of slow production. Each item in our catalog is the
                                result of days, sometimes weeks, of focused labor by local families who have passed these skills
                                through generations.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Client-Side Tab Filtering Logic -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tabs = document.querySelectorAll('#craft-tabs button');
                    const cards = document.querySelectorAll('.craft-card');

                    tabs.forEach(tab => {
                        tab.addEventListener('click', function () {
                            // Reset all tabs active states
                            tabs.forEach(t => {
                                t.classList.remove('border-[#2B4C3F]', 'text-[#2B4C3F]', 'font-semibold', 'active-tab-btn');
                                t.classList.add('border-transparent', 'text-[#8A9C91]', 'font-medium');
                            });

                            // Set clicked tab active
                            this.classList.remove('border-transparent', 'text-[#8A9C91]', 'font-medium');
                            this.classList.add('border-[#2B4C3F]', 'text-[#2B4C3F]', 'font-semibold', 'active-tab-btn');

                            const filterValue = this.getAttribute('data-filter');

                            cards.forEach(card => {
                                const cardCategory = card.getAttribute('data-category');
                                if (filterValue === 'all' || cardCategory === filterValue) {
                                    card.style.display = 'flex';
                                } else {
                                    card.style.display = 'none';
                                }
                            });
                        });
                    });
                });
            </script>
        @endif

    </div>
@endsection