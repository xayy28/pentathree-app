<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Natasha Homestay</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *::-webkit-scrollbar {
            display: none;
        }

        * {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-sans {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .font-cursive {
            font-family: 'Dancing Script', cursive;
        }
    </style>
</head>

<body class="bg-[#F3F4F6] text-[#1E362C] font-sans min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 md:h-20">

                <!-- Left: Logo & Brand Name -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                        <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Natasha Homestay Logo"
                            class="h-9 w-9 rounded-full object-cover border border-[#E6E4DD]/60">
                        <span
                            class="text-xs sm:text-sm font-serif font-semibold tracking-[0.15em] text-[#2B4C3F] uppercase">
                            Natasha Homestay
                        </span>
                    </a>
                </div>

                <!-- Center: Navigation Links (Desktop) -->
                <nav class="hidden md:flex space-x-8 lg:space-x-10">
                    <a href="{{ route('dashboard') }}"
                        class="text-xs md:text-[13px] lg:text-sm font-semibold tracking-[0.15em] uppercase pb-2 transition-all {{ request()->routeIs('dashboard') ? 'border-b-2 border-[#1E362C] text-[#1E362C]' : 'text-[#8A9C91] hover:text-[#1E362C]' }}">
                        Explore
                    </a>
                    <a href="{{ route('user.homestay') }}"
                        class="text-xs md:text-[13px] lg:text-sm font-semibold tracking-[0.15em] uppercase pb-2 transition-all {{ request()->routeIs('user.homestay') ? 'border-b-2 border-[#1E362C] text-[#1E362C]' : 'text-[#8A9C91] hover:text-[#1E362C]' }}">
                        Homestay
                    </a>
                    <a href="{{ route('user.souvenir') }}"
                        class="text-xs md:text-[13px] lg:text-sm font-semibold tracking-[0.15em] uppercase pb-2 transition-all {{ request()->routeIs('user.souvenir') ? 'border-b-2 border-[#1E362C] text-[#1E362C]' : 'text-[#8A9C91] hover:text-[#1E362C]' }}">
                        Souvenir
                    </a>
                </nav>

                <!-- Right: Search Bar & Profile Avatar (Desktop) -->
                <div class="hidden md:flex items-center gap-6">
                    <!-- Search Input -->
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#8A9C91] group-focus-within:text-[#1E362C] transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" placeholder="Search..."
                            class="bg-[#F3F4F6] text-[#1E362C] placeholder-[#8A9C91]/70 text-sm rounded-full pl-10 pr-4 py-2 w-48 focus:w-60 border border-transparent hover:border-gray-200 focus:border-[#1E362C] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#EAF2EE]/50 transition-all duration-300">
                    </div>

                    <!-- Profile Avatar Dropdown (Initials in Green Circle) -->
                    <div class="relative" id="profile-dropdown-container">
                        <button id="profile-dropdown-btn"
                            class="w-9 h-9 bg-[#EAF2EE] hover:bg-[#dcede5] rounded-full overflow-hidden flex items-center justify-center border border-[#A7C5B5]/60 text-[#2B4C3F] font-semibold text-xs flex-shrink-0 transition-colors focus:outline-none">
                            @if (auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar"
                                    class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown-menu"
                            class="absolute right-0 mt-2 w-48 bg-white border border-[#E6E4DD] rounded-xl shadow-lg py-2 hidden z-50">
                            <div class="px-4 py-2.5 border-b border-[#F2F0EA]">
                                <p class="text-xs text-[#8A9C91] mb-0.5">Logged in as</p>
                                <p class="text-sm font-semibold text-[#2C3E35] truncate leading-tight">
                                    {{ auth()->user()->nama }}</p>
                                <p class="text-[9px] font-bold uppercase tracking-wider text-[#8A9C91] mt-0.5">
                                    {{ auth()->user()->user_id }}</p>
                            </div>
                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-sm text-[#2C3E35] hover:bg-[#FAF9F6]">Profil</a>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-[#2C3E35] hover:bg-[#FAF9F6]">Edit Profil</a>
                            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="w-full text-left block px-4 py-2 text-sm text-[#E65F5F] hover:bg-[#FDF2F2]">
                                Logout
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hamburger Button (Mobile) -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn"
                        class="p-2 text-[#2B4C3F] hover:bg-[#FAF9F6] rounded-lg focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path id="mobile-menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu"
            class="hidden md:hidden border-t border-[#E6E4DD] bg-white px-4 pt-2 pb-4 space-y-3 shadow-md">
            <!-- Search for mobile -->
            <div class="relative mt-2 group">
                <span
                    class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#8A9C91] group-focus-within:text-[#2B4C3F] transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Search"
                    class="bg-transparent text-[#2C3E35] placeholder-[#8A9C91]/70 border border-[#E6E4DD] hover:border-[#2B4C3F]/30 focus:border-[#2B4C3F] text-sm rounded-full pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-4 focus:ring-[#EAF2EE]/50 transition-all duration-300">
            </div>

            <nav class="flex flex-col space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'text-[#5C6E65] hover:bg-[#FAF9F6]' }}">
                    Explore
                </a>
                <a href="{{ route('user.homestay') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('user.homestay') ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'text-[#5C6E65] hover:bg-[#FAF9F6]' }}">
                    Homestay
                </a>
                <a href="{{ route('user.souvenir') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('user.souvenir') ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'text-[#5C6E65] hover:bg-[#FAF9F6]' }}">
                    Souvenir
                </a>
                <a href="{{ route('profile.show') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-[#EAF2EE] text-[#2B4C3F]' : 'text-[#5C6E65] hover:bg-[#FAF9F6]' }}">
                    Profil
                </a>
            </nav>

            <div class="border-t border-[#F2F0EA] pt-3">
                <div class="px-3 py-2">
                    <p class="text-xs text-[#8A9C91]">Logged in as</p>
                    <p class="text-sm font-semibold text-[#2C3E35]">{{ auth()->user()->nama }}</p>
                </div>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center justify-center gap-2 mt-2 px-4 py-2.5 bg-[#E65F5F]/10 text-[#E65F5F] hover:bg-[#E65F5F]/20 transition-all rounded-lg text-sm font-semibold">
                    Logout
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        <!-- Success/Error Toast Flash Notifications -->
        @if (session('success') || session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                @if (session('success'))
                    <div
                        class="p-4 bg-[#EAF2EE] border border-[#A7C5B5] text-[#2B4C3F] text-sm rounded-xl flex items-start gap-3 shadow-sm mb-6">
                        <svg class="w-5 h-5 text-[#2B4C3F] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold">Sukses!</span> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="p-4 bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C] text-sm rounded-xl flex items-start gap-3 shadow-sm mb-6">
                        <svg class="w-5 h-5 text-[#9B1C1C] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold">Gagal!</span> {{ session('error') }}
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Secure Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Navigation & Dropdown Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Dropdown
            const dropdownBtn = document.getElementById('profile-dropdown-btn');
            const dropdownMenu = document.getElementById('profile-dropdown-menu');
            const dropdownContainer = document.getElementById('profile-dropdown-container');

            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!dropdownContainer.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Mobile Menu
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = document.getElementById('mobile-menu-icon');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');

                    // Toggle menu icon between burger and close x
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                    } else {
                        mobileMenuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                    }
                });
            }
        });
    </script>
</body>

</html>
