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
        <!-- Navigation -->
        <nav
            class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">A</div>
                <span class="text-xl font-bold tracking-tight">amikomeventhub</span>
            </div>
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="{{ route('home') }}" class="{{ $homeActive ? 'text-indigo-600' : 'hover:text-indigo-600 transition' }}">Jelajahi</a>
                <a href="{{ session('ticket_order_id') ? route('ticket', ['order_id' => session('ticket_order_id')]) : (auth()->check() ? route('ticket', ['email' => auth()->user()->email]) : route('ticket')) }}" class="{{ $ticketActive ? 'text-indigo-600' : 'hover:text-indigo-600 transition' }}">Tiket Saya</a>
                @auth
                    <a href="{{ route('reviews.index') }}" class="hover:text-indigo-600 transition">Review Saya</a>
                @endauth
                <a href="#" class="hover:text-indigo-600 transition">Kategori</a>
                <a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a>
            </div>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition">Login</a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Daftar</a>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Profil</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-900 font-semibold hover:bg-slate-200 transition">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </nav>
    @endunless

    @yield('content')

    @if(!View::hasSection('hideFooter'))
    <!-- Footer -->
    <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                        AH</div>
                    <span class="text-2xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan
                    penyelenggara profesional.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Kategori</h4>
                <ul class="space-y-4">
                    <li><a href="/" class="hover:text-white transition">Semua Kategori</a></li>
                    @isset($categories)
                        @foreach($categories as $cat)
                            <li>
                                <a href="/?category={{ $cat->slug }}" class="hover:text-white transition">
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
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('home') }}#event" class="hover:text-white transition">Event</a></li>
                    <li><a href="{{ route('home') }}#partner" class="hover:text-white transition">Tentang Kami</a></li>
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