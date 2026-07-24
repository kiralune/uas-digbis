@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<main class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <p class="text-sm font-semibold text-indigo-600">AKUN SAYA</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-slate-900">
                Profil & Aktivitas
            </h1>
            <p class="mt-2 text-slate-500">
                Kelola informasi akun, transaksi, dan tiket event Anda.
            </p>
        </div>

        <div class="grid items-start gap-6 lg:grid-cols-[280px_1fr]">
            <!-- Sidebar -->
            <aside class="space-y-4 lg:sticky lg:top-6">
                <!-- User Card -->
                <div class="overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-sm">
                    <div class="h-20 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

                    <div class="-mt-10 px-6 pb-6">
                        <div class="flex h-20 w-20 items-center justify-center rounded-3xl border-4 border-white bg-indigo-100 text-3xl font-black text-indigo-700 shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <h2 class="mt-4 truncate text-xl font-black text-slate-900">
                            {{ auth()->user()->name }}
                        </h2>

                        <p class="mt-1 truncate text-sm text-slate-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="px-3 pb-3 text-xs font-bold uppercase tracking-widest text-slate-400">
                        Menu Profil
                    </p>

                    <div class="space-y-1">
                        <button
                            type="button"
                            data-profile-tab="overview"
                            class="profile-tab flex w-full items-center gap-3 rounded-2xl bg-indigo-50 px-4 py-3 text-left font-semibold text-indigo-700 transition"
                        >
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-14 0v8a2 2 0 002 2h3m10-10v8a2 2 0 01-2 2h-3m-6 0h6"></path>
                            </svg>
                            Ringkasan
                        </button>

                        <button
                            type="button"
                            data-profile-tab="transactions"
                            class="profile-tab flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-indigo-700"
                        >
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 3c-2.757 0-5.29.935-7.305 2.505M5.082 5.555A11.98 11.98 0 003 12c0 2.757.935 5.29 2.505 7.305M18.918 18.445A11.98 11.98 0 0021 12c0-2.757-.935-5.29-2.505-7.305"></path>
                            </svg>
                            Riwayat Transaksi
                        </button>

                        <button
                            type="button"
                            data-profile-tab="tickets"
                            class="profile-tab flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-indigo-700"
                        >
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 18l2-2 4 4M7 6h.01M3 10h.01M7 14h.01M3 18h.01M11 6h10M11 10h10M11 14h2m-2 4h2"></path>
                            </svg>
                            Tiket Saya
                        </button>

                        <button
                            type="button"
                            data-profile-tab="reviews"
                            class="profile-tab flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-indigo-700"
                        >
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h7m-7 4h10M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                            </svg>
                            Rating & Review
                        </button>
                    </div>

                    <div class="my-4 border-t border-slate-100"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left font-semibold text-red-600 transition hover:bg-red-50"
                        >
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>

                <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-5">
                    <p class="font-bold text-indigo-900">Butuh bantuan?</p>
                    <p class="mt-1 text-sm leading-6 text-indigo-700">
                        Hubungi kami melalui
                        <a href="mailto:support@eventtiket.com" class="font-semibold underline">
                            support@eventtiket.com
                        </a>.
                    </p>
                </div>
            </aside>

            <!-- Content -->
            <section>
                <!-- Overview Panel -->
                <div data-profile-panel="overview" class="profile-panel space-y-6">
                    <div class="rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-700 p-7 text-white shadow-lg shadow-indigo-200">
                        <p class="text-sm font-semibold text-indigo-100">SELAMAT DATANG KEMBALI</p>

                        <div class="mt-3 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                            <div>
                                <h2 class="text-3xl font-black">
                                    Halo, {{ auth()->user()->name }}!
                                </h2>
                                <p class="mt-2 text-indigo-100">
                                    Lihat aktivitas event dan pesanan terbaru Anda di sini.
                                </p>
                            </div>

                            <button
                                type="button"
                                data-open-profile-edit
                                class="rounded-2xl bg-white px-5 py-3 text-sm font-bold text-indigo-700 transition hover:bg-indigo-50"
                            >
                                Edit Profil
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 3c-2.757 0-5.29.935-7.305 2.505"></path>
                                </svg>
                            </div>
                            <p class="mt-5 text-3xl font-black text-slate-900">{{ $transactions->count() }}</p>
                            <p class="mt-1 text-sm text-slate-500">Total Transaksi</p>
                        </div>

                        <button
                            type="button"
                            data-open-tickets
                            class="rounded-3xl border border-slate-200 bg-white p-5 text-left shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 18l2-2 4 4M7 6h.01M3 10h.01M7 14h.01M3 18h.01M11 6h10M11 10h10M11 14h2m-2 4h2"></path>
                                </svg>
                            </div>
                            <p class="mt-5 text-3xl font-black text-slate-900">{{ $transactions->count() }}</p>
                            <p class="mt-1 text-sm text-slate-500">Tiket Saya</p>
                        </button>

                        <button
                            type="button"
                            data-open-reviews
                            class="rounded-3xl border border-slate-200 bg-white p-5 text-left shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M12 4h9m-9 8h9M4 6h.01M4 12h.01M4 18h.01"></path>
                                </svg>
                            </div>
                            <p class="mt-5 text-3xl font-black text-slate-900">{{ $pendingReviewCount ?? 0 }}</p>
                            <p class="mt-1 text-sm text-slate-500">Review Tertunda</p>
                        </button>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-black text-slate-900">Transaksi Terbaru</h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Ringkasan pesanan event terbaru Anda.
                                </p>
                            </div>

                            <button
                                type="button"
                                data-open-transactions
                                class="text-sm font-bold text-indigo-600 hover:text-indigo-700"
                            >
                                Lihat semua
                            </button>
                        </div>

                        @if($transactions->count() > 0)
                            <div class="mt-5 space-y-3">
                                @foreach($transactions->take(3) as $transaction)
                                    <div class="flex flex-col gap-3 rounded-2xl bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="font-bold text-slate-900">
                                                {{ $transaction->event?->name ?? 'Event' }}
                                            </p>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $transaction->created_at->format('d M Y') }}
                                                · {{ $transaction->order_id }}
                                            </p>
                                        </div>

                                        <div class="flex items-center justify-between gap-4 sm:justify-end">
                                            <p class="font-bold text-indigo-600">
                                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                            </p>

                                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ match($transaction->status) {
                                                'settlement' => 'bg-emerald-100 text-emerald-700',
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'cancel' => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-200 text-slate-700',
                                            } }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-5 rounded-2xl bg-slate-50 px-5 py-10 text-center">
                                <p class="font-semibold text-slate-700">Belum ada transaksi.</p>
                                <a href="{{ route('events.index') }}" class="mt-2 inline-block text-sm font-bold text-indigo-600 hover:text-indigo-700">
                                    Jelajahi event &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Transactions Panel -->
                <div data-profile-panel="transactions" class="profile-panel hidden">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-sm font-bold text-indigo-600">AKTIVITAS PESANAN</p>
                                <h2 class="mt-1 text-2xl font-black text-slate-900">
                                    Riwayat Transaksi
                                </h2>
                                <p class="mt-2 text-slate-500">
                                    Semua pembelian tiket event Anda.
                                </p>
                            </div>

                            <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-sm font-bold text-indigo-700">
                                {{ $transactions->count() }} Transaksi
                            </span>
                        </div>

                        @if($transactions->count() > 0)
                            <div class="mt-7 space-y-4">
                                @foreach($transactions as $transaction)
                                    <div class="rounded-3xl border border-slate-200 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/30">
                                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h3 class="text-lg font-black text-slate-900">
                                                        {{ $transaction->event?->name ?? 'Event' }}
                                                    </h3>

                                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ match($transaction->status) {
                                                        'settlement' => 'bg-emerald-100 text-emerald-700',
                                                        'pending' => 'bg-amber-100 text-amber-700',
                                                        'cancel' => 'bg-red-100 text-red-700',
                                                        default => 'bg-slate-100 text-slate-700',
                                                    } }}">
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </div>

                                                <p class="mt-2 text-sm text-slate-500">
                                                    Order ID: {{ $transaction->order_id }}
                                                </p>

                                                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-3 text-sm">
                                                    <div>
                                                        <p class="text-slate-400">Tanggal Event</p>
                                                        <p class="mt-1 font-semibold text-slate-700">
                                                            @if($transaction->event?->date)
                                                                {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-slate-400">Tanggal Pembelian</p>
                                                        <p class="mt-1 font-semibold text-slate-700">
                                                            {{ $transaction->created_at->format('d M Y') }}
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-slate-400">Total Pembayaran</p>
                                                        <p class="mt-1 font-bold text-indigo-600">
                                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <a
                                                href="{{ route('ticket', ['email' => auth()->user()->email]) }}"
                                                class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-indigo-700"
                                            >
                                                Lihat Tiket
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-7 rounded-3xl bg-slate-50 px-6 py-14 text-center">
                                <p class="text-lg font-bold text-slate-700">Belum ada transaksi</p>
                                <p class="mt-2 text-slate-500">
                                    Tiket event yang Anda beli akan muncul di sini.
                                </p>
                                <a
                                    href="{{ route('events.index') }}"
                                    class="mt-5 inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-indigo-700"
                                >
                                    Jelajahi Event
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tickets Panel -->
                <div data-profile-panel="tickets" class="profile-panel hidden">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-bold text-indigo-600">TIKET SAYA</p>
                                <h2 class="mt-1 text-2xl font-black text-slate-900">Daftar Tiket dan Transaksi</h2>
                                <p class="mt-2 text-slate-500">Semua transaksi tiket Anda ditampilkan di sini.</p>
                            </div>

                            <span class="rounded-full bg-indigo-50 px-4 py-2 text-sm font-bold text-indigo-700">
                                {{ $transactions->count() }} tiket
                            </span>
                        </div>

                        @if($transactions->isEmpty())
                            <div class="mt-8 rounded-3xl border border-slate-100 bg-slate-50 p-8 text-center">
                                <p class="text-lg font-bold text-slate-900">Belum ada tiket yang tersimpan.</p>
                                <p class="mt-2 text-sm text-slate-500">Setelah Anda membeli tiket, transaksi akan muncul di halaman ini.</p>
                                <a href="{{ route('events.index') }}" class="mt-6 inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">Jelajahi Event</a>
                            </div>
                        @else
                            <div class="mt-8 space-y-6">
                                @foreach($transactions as $transaction)
                                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                            <div>
                                                <p class="text-sm uppercase tracking-[0.3em] text-slate-400 font-black">{{ $transaction->event?->category->name ?? 'Event' }}</p>
                                                <p class="text-xl font-black text-slate-900">{{ $transaction->event?->title ?? $transaction->event?->name ?? 'Nama Event' }}</p>
                                                <p class="mt-2 text-sm text-slate-500">Order ID: {{ $transaction->order_id }}</p>
                                                <p class="mt-1 text-sm text-slate-500">Tanggal event: {{ optional($transaction->event?->date)->format('d M Y') ?? '-' }}</p>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-3">
                                                <span class="rounded-full px-4 py-2 text-sm font-bold {{ $transaction->status === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                                <span class="rounded-full px-4 py-2 bg-slate-100 text-slate-700 text-sm font-semibold">
                                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="text-sm text-slate-500">
                                                {{ $transaction->event?->location ? 'Lokasi: ' . $transaction->event->location : '' }}
                                            </div>

                                            <div class="flex flex-wrap gap-3">
                                                <a href="{{ route('ticket') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">Lihat Tiket</a>

                                                @php
                                                    $eventFinished = $transaction->event?->date ? now()->gte($transaction->event->date->copy()->addDay()) : false;
                                                    $canReview = $transaction->status === 'success' && $eventFinished;
                                                @endphp

                                                @if($transaction->review)
                                                    <span class="inline-flex items-center justify-center rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-bold text-emerald-700">Sudah direview</span>
                                                @elseif($canReview)
                                                    <a href="{{ route('reviews.create', $transaction->order_id) }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">Beri Rating</a>
                                                @else
                                                    <span class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-3 text-sm font-bold text-slate-700">Review belum tersedia</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reviews Panel -->
                <div data-profile-panel="reviews" class="profile-panel hidden">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-bold text-indigo-600">RATING & REVIEW</p>
                                <h2 class="mt-1 text-2xl font-black text-slate-900">Status Ulasan Anda</h2>
                                <p class="mt-2 text-slate-500">
                                    Pantau review yang sudah dikirim dan temukan event yang masih perlu Anda beri rating.
                                </p>
                            </div>

                            <div class="rounded-3xl bg-indigo-50 px-4 py-3 text-right text-sm font-black text-indigo-700 sm:text-left">
                                <p class="text-slate-500">Rating rata-rata</p>
                                <p class="mt-1 text-3xl">{{ $averageRating }}</p>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <p class="text-sm font-bold text-slate-500">Ulasan Terkirim</p>
                                <p class="mt-3 text-4xl font-black text-slate-900">{{ $reviewedCount ?? 0 }}</p>
                                <p class="mt-2 text-sm text-slate-500">Event yang sudah Anda review.</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <p class="text-sm font-bold text-slate-500">Review Tertunda</p>
                                <p class="mt-3 text-4xl font-black text-slate-900">{{ $pendingReviewCount ?? 0 }}</p>
                                <p class="mt-2 text-sm text-slate-500">Event yang bisa Anda beri rating sekarang.</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-black text-slate-900">Review Tertunda</h3>
                                    <p class="mt-2 text-sm text-slate-500">Isi review dari event yang sudah selesai.</p>
                                </div>

                                <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-bold text-amber-700">
                                    {{ $pendingReviewCount ?? 0 }} Tertunda
                                </span>
                            </div>

                            @if(isset($pendingReviewTransactions) && $pendingReviewTransactions->count())
                                <div class="mt-6 space-y-4">
                                    @foreach($pendingReviewTransactions as $transaction)
                                        <div class="rounded-3xl border border-slate-200 p-5 sm:flex sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $transaction->event?->name ?? 'Event' }}</p>
                                                <p class="mt-1 text-sm text-slate-500">
                                                    {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') }} · Order {{ $transaction->order_id }}
                                                </p>
                                            </div>

                                            <a
                                                href="{{ route('reviews.create', $transaction->order_id) }}"
                                                class="mt-4 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-indigo-700 sm:mt-0"
                                            >
                                                Isi Review
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-6 rounded-3xl bg-slate-50 px-6 py-10 text-center">
                                    <p class="font-semibold text-slate-700">Tidak ada review tertunda saat ini.</p>
                                    <p class="mt-2 text-sm text-slate-500">
                                        Kunjungi riwayat transaksi jika ingin melihat event yang sudah Anda beli.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-10">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-black text-slate-900">Review Dikirim</h3>
                                    <p class="mt-2 text-sm text-slate-500">Event yang sudah dinilai oleh Anda.</p>
                                </div>

                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-bold text-indigo-700">
                                    {{ $reviewedCount ?? 0 }} Terkirim
                                </span>
                            </div>

                            @if(isset($reviewTransactions) && $reviewTransactions->count())
                                <div class="mt-6 space-y-4">
                                    @foreach($reviewTransactions as $transaction)
                                        <div class="rounded-3xl border border-slate-200 p-5 sm:flex sm:items-center sm:justify-between">
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $transaction->event?->name ?? 'Event' }}</p>
                                                <p class="mt-1 text-sm text-slate-500">
                                                    Order {{ $transaction->order_id }} · {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') }}
                                                </p>
                                                <p class="mt-3 text-sm font-semibold text-slate-700">
                                                    Rating: {{ $transaction->review->rating }}/5
                                                </p>
                                            </div>

                                            <span class="mt-4 inline-flex items-center justify-center rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-bold text-emerald-700 sm:mt-0">
                                                Dilihat
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-6 rounded-3xl bg-slate-50 px-6 py-10 text-center">
                                    <p class="font-semibold text-slate-700">Belum ada review yang dikirim.</p>
                                    <p class="mt-2 text-sm text-slate-500">Setelah Anda mengisi review, ringkasannya akan muncul di sini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Panel -->
                <div data-profile-panel="edit-profile" class="profile-panel hidden">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <p class="text-sm font-bold text-indigo-600">PENGATURAN AKUN</p>
                        <h2 class="mt-1 text-2xl font-black text-slate-900">Edit Profil</h2>
                        <p class="mt-2 text-slate-500">
                            Perbarui nama dan alamat email akun Anda.
                        </p>

                        @if(session('success'))
                            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" class="mt-8 max-w-xl space-y-5">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name" class="mb-2 block text-sm font-bold text-slate-700">
                                    Nama Lengkap
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    required
                                    autocomplete="name"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                >

                                @error('name')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-bold text-slate-700">
                                    Alamat Email
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    required
                                    autocomplete="email"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                >

                                @error('email')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <button
                                    type="submit"
                                    class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-indigo-700"
                                >
                                    Simpan Perubahan
                                </button>

                                <button
                                    type="button"
                                    data-open-overview
                                    class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50"
                                >
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('[data-profile-tab]');
        const panels = document.querySelectorAll('[data-profile-panel]');

        function showPanel(panelName) {
            panels.forEach(function (panel) {
                panel.classList.toggle(
                    'hidden',
                    panel.dataset.profilePanel !== panelName
                );
            });

            tabs.forEach(function (tab) {
                const active = tab.dataset.profileTab === panelName;

                tab.classList.toggle('bg-indigo-50', active);
                tab.classList.toggle('text-indigo-700', active);
                tab.classList.toggle('text-slate-600', !active);
            });

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                showPanel(tab.dataset.profileTab);
            });
        });

        document.querySelectorAll('[data-open-transactions]').forEach(function (button) {
            button.addEventListener('click', function () {
                showPanel('transactions');
            });
        });

        document.querySelectorAll('[data-open-tickets]').forEach(function (button) {
            button.addEventListener('click', function () {
                showPanel('tickets');
            });
        });

        document.querySelectorAll('[data-open-reviews]').forEach(function (button) {
            button.addEventListener('click', function () {
                showPanel('reviews');
            });
        });

        document.querySelectorAll('[data-open-profile-edit]').forEach(function (button) {
            button.addEventListener('click', function () {
                showPanel('edit-profile');
            });
        });

        document.querySelectorAll('[data-open-overview]').forEach(function (button) {
            button.addEventListener('click', function () {
                showPanel('overview');
            });
        });
    });
</script>
@endsection