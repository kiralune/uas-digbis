<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex">
    <aside class="w-72 bg-slate-950 text-slate-200 p-6 flex flex-col gap-6 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-white text-slate-950 font-black flex items-center justify-center">A</div>
            <div>
                <p class="text-lg font-black text-white">AmikomEventHub</p>
                <p class="text-xs text-slate-400">Admin Panel</p>
            </div>
        </div>

        <nav class="space-y-2">
            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-500 px-3 mb-2">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Dashboard Admin
            </a>
            <a href="{{ route('admin.organizers.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.organizers.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Manajemen Organizer
            </a>
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Manajemen Event
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.transactions.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Manajemen Transaksi
            </a>
            <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.partners.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Manajemen Partner
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                Manajemen Kategori Event
            </a>
        </nav>

        <div class="mt-auto border-t border-slate-800 pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full rounded-2xl border border-slate-700 px-3 py-3 text-left text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-10">
        <header class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-600">Panel Superadmin</p>
                    <h1 class="text-3xl font-black text-slate-900">@yield('page_title', 'Dashboard Admin')</h1>
                    <p class="text-slate-500 mt-1">@yield('page_subtitle', 'Pantau pertumbuhan platform, organizer, event, transaksi, dan partner secara terpusat.')</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()?->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-500">Superadmin</p>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
