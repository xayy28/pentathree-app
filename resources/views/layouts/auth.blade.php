<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aura Stay & Style - Premium Homestay & Souvenir Booking System">
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

<body class="bg-[#F8F7F4] text-[#2C3E35] min-h-screen font-sans flex flex-col justify-between">

    <!-- Top Navbar -->
    <header
        class="border-b border-[#E6E4DD] bg-[#F8F7F4]/90 backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 sm:gap-3 hover:opacity-90 transition-opacity min-w-0">
                <img src="{{ asset('images/Logo-Natasha.jpg') }}" alt="Natasha Homestay Logo"
                    class="h-8 w-8 sm:h-12 sm:w-12 rounded-full object-cover shadow-sm border border-[#E6E4DD] flex-shrink-0">
                <span class="text-lg sm:text-2xl font-semibold font-serif text-[#2B4C3F] tracking-wide truncate">
                    Natasha Homestay
                </span>
            </a>

            <div class="flex items-center space-x-4 sm:space-x-6 flex-shrink-0">
                <a href="{{ route('login') }}"
                    class="text-xs sm:text-sm font-medium hover:text-[#2B4C3F] transition-colors whitespace-nowrap {{ request()->routeIs('login') ? 'text-[#2B4C3F] border-b-2 border-[#2B4C3F] pb-1' : 'text-[#5C6E65]' }}">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="text-xs sm:text-sm font-medium hover:text-[#2B4C3F] transition-colors whitespace-nowrap {{ request()->routeIs('register') ? 'text-[#2B4C3F] border-b-2 border-[#2B4C3F] pb-1' : 'text-[#5C6E65]' }}">
                    Sign Up
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center py-8 sm:py-10 px-4 sm:px-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#E6E4DD] bg-[#FAF9F6] py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 sm:gap-6">
            <div class="text-base sm:text-xl font-serif text-[#2B4C3F] font-semibold">
                Natasha Homestay
            </div>

            <div class="flex flex-wrap justify-center gap-x-6 sm:gap-x-8 gap-y-2 text-[11px] sm:text-xs text-[#5C6E65] font-medium">
                <a href="#" class="hover:text-[#2B4C3F] transition-colors">Privacy</a>
                <a href="#" class="hover:text-[#2B4C3F] transition-colors">Terms</a>
                <a href="#" class="hover:text-[#2B4C3F] transition-colors">Shipping</a>
                <a href="#" class="hover:text-[#2B4C3F] transition-colors">Contact</a>
            </div>

            <div class="text-[11px] sm:text-xs text-[#8A9C91] text-center">
                &copy; {{ date('Y') }} Natasha Homestay
            </div>
        </div>
    </footer>


</body>

</html>
