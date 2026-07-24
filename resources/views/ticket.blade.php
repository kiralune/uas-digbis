@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-10">
    @php
    $successTransactions = $transactions->where('status', 'success')->count();
    $activeTickets = $transactions->filter(function ($transaction) {
        return $transaction->status === 'success'
            && $transaction->event?->date
            && now()->lt($transaction->event->date->copy()->addDay());
    })->count();
    $pendingTransactions = $transactions->where('status', '!=', 'success')->count();
@endphp

<section class="relative overflow-hidden rounded-[2rem] bg-slate-950 shadow-2xl">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(99,102,241,0.45),_transparent_35%),radial-gradient(circle_at_bottom_left,_rgba(6,182,212,0.20),_transparent_35%)]"></div>
    <div class="absolute -right-16 top-10 h-64 w-64 rounded-full border border-white/10"></div>
    <div class="absolute -right-4 top-20 h-40 w-40 rounded-full border border-white/10"></div>

    <div class="relative grid gap-8 p-7 md:p-10 lg:grid-cols-[1fr_auto] lg:items-center">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 rounded-full border border-indigo-400/30 bg-indigo-400/10 px-3 py-1.5 text-xs font-bold text-indigo-200">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400"></span>
                Pusat tiket pribadi
            </div>

            <h1 class="mt-5 text-3xl font-black leading-tight text-white md:text-5xl">
                Semua pengalaman event-mu, dalam satu tempat.
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-300 md:text-base">
                Cek status transaksi, lihat detail tiket, dan berikan ulasan setelah event selesai.
            </p>

            <div class="mt-7 flex flex-wrap gap-3">
                <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur-sm">
                    <p class="text-2xl font-black text-white">{{ $transactions->count() }}</p>
                    <p class="mt-0.5 text-xs font-medium text-slate-300">Total transaksi</p>
                </div>

                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 backdrop-blur-sm">
                    <p class="text-2xl font-black text-emerald-300">{{ $activeTickets }}</p>
                    <p class="mt-0.5 text-xs font-medium text-emerald-100">Tiket aktif</p>
                </div>

                @if($pendingTransactions > 0)
                    <div class="rounded-2xl border border-amber-400/20 bg-amber-400/10 px-4 py-3 backdrop-blur-sm">
                        <p class="text-2xl font-black text-amber-300">{{ $pendingTransactions }}</p>
                        <p class="mt-0.5 text-xs font-medium text-amber-100">Menunggu pembayaran</p>
                    </div>
                @endif

                @php
                    $expiredTickets = $transactions->filter(function ($transaction) {
                        return $transaction->status === 'success'
                            && $transaction->event?->date
                            && now()->gte($transaction->event->date->copy()->addDay());
                    })->count();
                @endphp

                @if($expiredTickets > 0)
                    <div class="rounded-2xl border border-slate-400/20 bg-slate-100/80 px-4 py-3 backdrop-blur-sm">
                        <p class="text-2xl font-black text-slate-700">{{ $expiredTickets }}</p>
                        <p class="mt-0.5 text-xs font-medium text-slate-500">Tiket tidak aktif</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="hidden lg:block">
            <div class="relative w-72 rotate-3 rounded-[2rem] border border-white/15 bg-white/10 p-5 shadow-2xl backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 4H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2zM9 9h6m-6 4h6m-6 4h3" />
                        </svg>
                    </div>

                    <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-xs font-bold text-emerald-300">
                        Tersimpan aman
                    </span>
                </div>

                <p class="mt-8 text-xs font-bold uppercase tracking-[0.25em] text-indigo-200">
                    AmikomEventHub
                </p>
                <p class="mt-2 text-2xl font-black text-white">E-Ticket</p>

                <div class="mt-8 border-t border-white/10 pt-4 text-sm text-slate-300">
                    Detail event dan transaksi tersedia kapan saja.
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="space-y-6">
        @if($transactions->isEmpty())
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">
                <p class="font-bold text-slate-900">Belum ada tiket yang tersimpan.</p>
                <p class="text-slate-500 mt-2">Kalau sudah ada pembelian, tiket akan tampil otomatis di sini.</p>
            </div>
        @else
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">Daftar Tiket</p>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900 mt-1">Seluruh transaksi terbaru</h2>
                </div>
                <div class="px-4 py-3 bg-slate-100 rounded-2xl text-slate-700 font-bold">
                    {{ $transactions->count() }} tiket tampil
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                @foreach($transactions as $transaction)
                    @php
                        $eventFinished = now()->gte($transaction->event->date->copy()->addDay());
                        $canReview = $transaction->status === 'success' && $eventFinished;
                        $reviewOpenAt = $transaction->event->date->copy()->addDay();
                        $posterPath = $transaction->event->poster_path;
                        $posterUrl = $posterPath ? (\Illuminate\Support\Facades\Storage::disk('public')->exists($posterPath) ? asset('storage/' . $posterPath) : asset('storage/' . $posterPath)) : 'https://placehold.co/480x640';
                    @endphp

                    <article class="bg-white rounded-[2.25rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                            <div class="bg-slate-950 text-white lg:border-r border-slate-800 overflow-hidden">
                                <div class="h-64 lg:h-full lg:min-h-[28rem] relative">
                                    <img src="{{ $posterUrl }}" alt="{{ $transaction->event->title }}" class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                                    <div class="absolute inset-x-0 bottom-0 p-8 lg:p-10 space-y-4">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-200 font-black">E-Ticket</p>
                                        <h3 class="text-3xl font-black leading-tight">{{ $transaction->event->title }}</h3>
                                        <p class="text-slate-300">{{ $transaction->event->partner->name ?? '-' }}</p>
                                        <div class="inline-flex px-3 py-1 rounded-full text-xs font-black {{ $transaction->status === 'success' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                                            {{ strtoupper($transaction->status) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-2 p-8 lg:p-10 space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Nama Pembeli</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $transaction->customer_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Order ID</p>
                                        <p class="mt-2 font-mono font-bold text-slate-900">{{ $transaction->order_id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Tanggal Acara</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $transaction->event->date->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Lokasi</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $transaction->event->location }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 rounded-[1.75rem] bg-slate-50 border border-slate-100 p-6">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500">Total Tagihan</p>
                                        <p class="text-2xl font-black text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="flex flex-wrap gap-3">
                                        @php
                                            $ticketExpired = $transaction->status === 'success'
                                                && $transaction->event?->date
                                                && now()->gte($transaction->event->date->copy()->addDay());
                                            $ticketActive = $transaction->status === 'success' && ! $ticketExpired;
                                        @endphp

                                        @if($ticketActive)
                                            <span class="px-4 py-2 rounded-2xl bg-emerald-100 text-emerald-700 font-bold">Tiket aktif</span>
                                        @elseif($ticketExpired)
                                            <span class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-600 font-bold">Tiket tidak aktif</span>
                                        @else
                                            <span class="px-4 py-2 rounded-2xl bg-amber-100 text-amber-700 font-bold">Menunggu pembayaran</span>
                                        @endif

                                        @if($transaction->review)
                                            <span class="px-4 py-2 rounded-2xl bg-indigo-100 text-indigo-700 font-bold">Sudah direview</span>
                                            <a href="{{ route('reviews.edit', $transaction->order_id) }}" class="px-4 py-2 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition">
                                                Edit Review
                                            </a>
                                        @elseif($canReview)
                                            <a href="{{ route('reviews.create', $transaction->order_id) }}" class="px-4 py-2 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">
                                                Beri Rating
                                            </a>
                                        @else
                                            <span class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-600 font-bold">Review terbuka setelah acara selesai</span>
                                        @endif
                                    </div>
                                </div>

                                @if($transaction->review)
                                    <div class="rounded-[1.75rem] border border-slate-100 bg-white p-6">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-bold uppercase tracking-widest text-slate-400">Rating kamu</p>
                                                <p class="text-2xl font-black text-indigo-600 mt-1">{{ str_repeat('★', (int) $transaction->review->rating) }}</p>
                                            </div>
                                            <p class="text-sm text-slate-400">{{ optional($transaction->review->submitted_at)->format('d M Y H:i') }}</p>
                                        </div>
                                        <p class="mt-4 text-slate-600">{{ $transaction->review->testimonial ?: 'Tidak ada testimoni tertulis.' }}</p>
                                    </div>
                                @elseif($canReview)
                                    <div class="rounded-[1.75rem] border border-indigo-100 bg-indigo-50 p-6 text-indigo-900">
                                        Acara ini sudah lewat, jadi kamu bisa langsung isi rating dari tombol di atas.
                                    </div>
                                @elseif($transaction->status === 'success')
                                    <div class="rounded-[1.75rem] border border-amber-100 bg-amber-50 p-6 text-amber-900">
                                        Rating belum dibuka. Tombol akan muncul setelah <strong>{{ $reviewOpenAt->format('d M Y H:i') }}</strong>.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</main>
@endsection