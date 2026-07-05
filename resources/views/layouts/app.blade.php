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
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
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
    </style>
</head>

<body class="bg-[#F8F7F4] text-[#2C3E35] font-sans min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#2B4C3F] text-[#FAF9F6] hidden md:flex flex-col flex-shrink-0 shadow-lg">
        <div class="h-20 flex items-center px-6 border-b border-[#3B5D50]">
            <a href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Natasha Homestay Logo"
                    class="h-10 w-10 rounded-full object-cover border-2 border-white/30 flex-shrink-0">
                <span class="text-base font-serif font-semibold tracking-wide text-white leading-tight">
                    Natasha Homestay
                </span>
            </a>
        </div>

        <div class="flex-grow flex flex-col justify-between py-6">
            <!-- Sidebar Navigation -->
            <nav class="px-4 space-y-1.5">
                @if(auth()->user()->role === 'admin')
                    <!-- ADMIN NAVIGATION -->
                    <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-[#A7C5B5] opacity-80">
                        Admin Menu
                    </div>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.homestay') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.homestay*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Kelola Homestay
                    </a>

                    <a href="{{ route('admin.kategori-homestay') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.kategori-homestay*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16">
                            </path>
                        </svg>
                        Kategori Homestay
                    </a>

                    <a href="{{ route('admin.souvenir') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.souvenir*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Kelola Souvenir
                    </a>

                    <a href="{{ route('admin.reservasi') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reservasi*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Reservasi Homestay
                    </a>

                    <a href="{{ route('admin.pembayaran') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.pembayaran*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 8h6m-5 4h3m-7 8h10a2 2 0 002-2V6a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Pembayaran Souvenir
                    </a>

                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.laporan') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Laporan
                    </a>
                @else
                    <!-- USER NAVIGATION -->
                    <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-[#A7C5B5] opacity-80">
                        User Menu
                    </div>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Dashboard & Profil
                    </a>

                    <a href="{{ route('user.homestay') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.homestay') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Menu Homestay
                    </a>

                    <a href="{{ route('user.souvenir') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.souvenir') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Menu Souvenir
                    </a>

                    <a href="{{ route('user.reservasi') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.reservasi') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Riwayat Pesanan
                    </a>
                @endif
            </nav>

            <!-- Bottom Action Logout -->
            <div class="px-4">
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#E65F5F]/10 text-[#FF9E9E] hover:bg-[#E65F5F]/20 hover:text-white transition-colors duration-200 rounded-lg text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Section (Header + Content) -->
    <div class="flex-grow flex flex-col min-w-0 h-screen">

        <!-- Header -->
        <header
            class="h-16 sm:h-20 bg-white border-b border-[#E6E4DD] flex items-center justify-between px-4 sm:px-10 flex-shrink-0 sticky top-0 z-10">
            <!-- Mobile Brand Indicator + Sidebar Toggle -->
            <div class="md:hidden flex items-center gap-1 sm:gap-2 min-w-0">
                <button id="sidebar-toggle" aria-label="Toggle sidebar navigation"
                    class="p-1.5 sm:p-2 text-[#2B4C3F] hover:bg-[#EAF2EE] rounded-lg transition-colors">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Logo"
                    class="h-7 w-7 sm:h-9 sm:w-9 rounded-full object-cover border border-[#E6E4DD] flex-shrink-0">
                <span class="text-sm sm:text-base font-serif font-semibold text-[#2B4C3F] truncate">Natasha
                    Homestay</span>
            </div>

            <!-- Dashboard Title -->
            <div class="hidden md:block text-sm font-semibold uppercase tracking-wider text-[#5C6E65]">
                System Dashboard &mdash; {{ ucfirst(auth()->user()->role) }}
            </div>

            <!-- Profile Widget -->
            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                <div class="text-right hidden sm:block">
                    <div class="text-xs sm:text-sm font-semibold text-[#2C3E35] leading-tight">
                        {{ auth()->user()->nama }}
                    </div>
                    <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]">
                        {{ auth()->user()->user_id }}
                    </div>
                </div>
                <div
                    class="w-8 h-8 sm:w-10 sm:h-10 bg-[#EAF2EE] rounded-full flex items-center justify-center border border-[#A7C5B5] text-[#2B4C3F] font-semibold text-xs sm:text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                </div>
                <!-- Mobile Logout Button -->
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="md:hidden p-1.5 sm:p-2 text-[#E65F5F] hover:bg-[#E65F5F]/10 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay"
            class="md:hidden fixed inset-0 bg-black/50 z-30 hidden transition-opacity duration-300"></div>

        <!-- Mobile Sidebar Drawer -->
        <aside id="mobile-sidebar"
            class="md:hidden fixed top-0 left-0 h-full w-72 max-w-[85vw] bg-[#2B4C3F] text-[#FAF9F6] z-40 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="h-20 flex items-center justify-between px-6 border-b border-[#3B5D50]">
                <a href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Logo"
                        class="h-10 w-10 rounded-full object-cover border-2 border-white/30 flex-shrink-0">
                    <span class="text-base font-serif font-semibold tracking-wide text-white leading-tight">
                        Natasha Homestay
                    </span>
                </a>
                <button id="sidebar-close" aria-label="Close sidebar"
                    class="p-2 text-[#A7C5B5] hover:text-white hover:bg-[#3B5D50] rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow flex flex-col justify-between py-6">
                <nav class="px-4 space-y-1.5">
                    @if(auth()->user()->role === 'admin')
                        <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-[#A7C5B5] opacity-80">
                            Admin Menu
                        </div>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.homestay') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.homestay*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Kelola Homestay
                        </a>
                        <a href="{{ route('admin.kategori-homestay') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.kategori-homestay*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Kategori Homestay
                        </a>
                        <a href="{{ route('admin.souvenir') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.souvenir*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Kelola Souvenir
                        </a>
                        <a href="{{ route('admin.reservasi') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reservasi*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Reservasi Homestay
                        </a>
                        <a href="{{ route('admin.pembayaran') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.pembayaran*') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 8h6m-5 4h3m-7 8h10a2 2 0 002-2V6a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Pembayaran Souvenir
                        </a>
                        <a href="{{ route('admin.laporan') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.laporan') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Laporan
                        </a>
                    @else
                        <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-[#A7C5B5] opacity-80">
                            User Menu
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Dashboard & Profil
                        </a>
                        <a href="{{ route('user.homestay') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.homestay') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Menu Homestay
                        </a>
                        <a href="{{ route('user.souvenir') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.souvenir') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Menu Souvenir
                        </a>
                        <a href="{{ route('user.reservasi') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.reservasi') ? 'bg-[#3B5D50] text-white' : 'text-[#A7C5B5] hover:bg-[#325547] hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Riwayat Pesanan
                        </a>
                    @endif
                </nav>
                <div class="px-4 mt-6">
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#E65F5F]/10 text-[#FF9E9E] hover:bg-[#E65F5F]/20 hover:text-white transition-colors duration-200 rounded-lg text-sm font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </aside>

        <!-- Dynamic Content -->
        <main class="flex-grow overflow-y-auto">
            <div class="p-4 sm:p-6 lg:p-10 min-h-full flex flex-col justify-between">
                <div class="flex-grow">
                    <!-- Success/Error Toast Flash Notifications -->
                    @if(session('success'))
                        <div
                            class="mb-6 sm:mb-8 p-3 sm:p-4 bg-[#EAF2EE] border border-[#A7C5B5] text-[#2B4C3F] text-sm rounded-xl flex items-start gap-3 shadow-sm">
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

                    @if(session('error'))
                        <div
                            class="mb-6 sm:mb-8 p-3 sm:p-4 bg-[#FDF2F2] border border-[#F5C2C2] text-[#9B1C1C] text-sm rounded-xl flex items-start gap-3 shadow-sm">
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

                    @yield('content')
                </div>

                <!-- Minimal Admin Footer -->
                <footer
                    class="mt-12 pt-6 border-t border-[#E6E4DD]/80 flex flex-col sm:flex-row justify-between items-center gap-2">
                    <p class="text-xs text-[#8A9C91]">
                        &copy; 2026 PentaThree. All Rights Reserved.
                    </p>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#8A9C91]/80">
                        Admin Portal
                    </span>
                </footer>
            </div>
        </main>
    </div>

    <!-- Secure Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const iconOpen = document.getElementById('sidebar-icon-open');
            const iconClose = document.getElementById('sidebar-icon-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                overlay.classList.add('block');
                document.body.style.overflow = 'hidden';
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                overlay.classList.remove('block');
                document.body.style.overflow = '';
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }

            if (toggle) {
                toggle.addEventListener('click', openSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when a nav link is clicked
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeSidebar);
            });
        });
    </script>
</body>

</html>
