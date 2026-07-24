<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    @unless(View::hasSection('hideNav'))
        @php
            $homeActive = request()->routeIs('home');
            $ticketActive = request()->routeIs('ticket');
        @endphp

        <nav
            class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                    A
                </div>

                <span class="text-xl font-bold tracking-tight">
                    AmikomEventHub
                </span>
            </div>

            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="{{ route('home') }}"
                    class="{{ $homeActive ? 'text-indigo-600' : 'hover:text-indigo-600 transition' }}">
                    Beranda
                </a>

                @auth
                    <a href="{{ route('ticket') }}"
                        class="{{ $ticketActive ? 'text-indigo-600' : 'hover:text-indigo-600 transition' }}">
                        Tiket Saya
                    </a>
                @endauth

                <div class="relative group">
                    <a href="{{ route('home') }}#events"
                        class="inline-flex items-center gap-1 hover:text-indigo-600 transition"
                        aria-haspopup="true">
                        Event

                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m6 9 6 6 6-6" />
                        </svg>
                    </a>

                    <div
                        class="absolute left-1/2 top-full z-50 hidden w-60 -translate-x-1/2 pt-4 group-hover:block group-focus-within:block">

                        <div
                            class="overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-xl shadow-slate-200/70">

                            <a href="{{ route('home') }}#events"
                                class="block rounded-xl px-4 py-3 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">
                                Semua Kategori
                            </a>

                            @isset($categories)
                                @foreach($categories as $cat)
                                    <a href="{{ route('home') }}?category={{ $cat->slug }}#events"
                                        class="block rounded-xl px-4 py-3 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            @else
                                <p class="px-4 py-3 text-sm text-slate-400">
                                    Kategori belum tersedia.
                                </p>
                            @endisset
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}#partner" class="hover:text-indigo-600 transition">
                    Tentang Kami
                </a>
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                        Daftar
                    </a>
                @else
                    <a href="{{ route('profile') }}"
                        class="group inline-flex items-center gap-2 rounded-xl border border-indigo-100 bg-white px-3 py-2 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <span class="pr-1 text-sm font-semibold text-slate-700 group-hover:text-indigo-700">
                            Profil
                        </span>

                        <svg class="h-4 w-4 text-slate-400 group-hover:text-indigo-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                @endguest
            </div>
        </nav>
    @endunless

    @yield('content')

    @if(!View::hasSection('hideFooter'))
        <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                            AH
                        </div>

                        <span class="text-2xl font-bold text-white">
                            AmikomEventHub
                        </span>
                    </div>

                    <p class="max-w-xs text-indigo-300">
                        Platform reservasi tiket event online terbaik untuk mahasiswa dan
                        penyelenggara profesional.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">Kategori</h4>

                    <ul class="space-y-4">
                        <li>
                            <a href="/" class="hover:text-white transition">
                                Semua Kategori
                            </a>
                        </li>

                        @isset($categories)
                            @foreach($categories as $cat)
                                <li>
                                    <a href="/?category={{ $cat->slug }}"
                                        class="hover:text-white transition">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        @endisset
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>

                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-white transition">
                                Beranda
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('home') }}#events" class="hover:text-white transition">
                                Event
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('home') }}#partner" class="hover:text-white transition">
                                Tentang Kami
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>

                    <ul class="space-y-4">
                        <li>support@eventtiket.com</li>
                        <li>+62 812 3456 7890</li>
                    </ul>
                </div>
            </div>

            <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
                &copy; 2024 AmikomEventHub. Built with Laravel & Tailwind CSS.
            </div>
        </footer>
    @endif

</body>

</html>