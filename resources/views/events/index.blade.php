@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-indigo-600 font-bold">Semua Event</p>
            <h1 class="mt-3 text-4xl font-black text-slate-900">Event dari semua organizer</h1>
            <p class="mt-3 text-slate-500 max-w-2xl">Telusuri semua event yang telah diunggah oleh semua organizer di platform AmikomEventHub.</p>
        </div>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('events.index') }}" class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 {{ request()->category ? 'bg-slate-100' : 'bg-indigo-600 text-white' }} transition">
            Semua Kategori
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('events.index', ['category' => $cat->slug]) }}"
                class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition {{ request()->category === $cat->slug ? 'bg-indigo-600 text-white border-transparent' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
        @forelse($events as $event)
            @php
                $posterUrl = $event->poster_path
                    ? (str_starts_with($event->poster_path, 'http')
                        ? $event->poster_path
                        : asset('storage/' . ltrim($event->poster_path, '/')))
                    : 'https://placehold.co/640x480?text=No+Image';

                $soldOut = isset($event->stock) && $event->stock <= 0;
            @endphp

            <article class="group bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-xl transition">
                <div class="relative overflow-hidden aspect-[16/9] bg-slate-100">
                    <img src="{{ $posterUrl }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 {{ $soldOut ? 'grayscale' : 'group-hover:scale-105' }}">
                    <span class="absolute top-3 left-3 px-2 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-semibold uppercase text-indigo-600">
                        {{ $event->category->name ?? 'Tanpa Kategori' }}
                    </span>

                    @if($soldOut)
                        <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center">
                            <span class="px-3 py-1.5 bg-slate-800/90 text-white rounded-full font-semibold text-[11px]">
                                Tiket Habis
                            </span>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="text-lg font-bold mb-1 group-hover:text-indigo-600 transition">
                        {{ $event->title }}
                    </h3>

                    <div class="flex flex-col gap-1.5 text-slate-500 text-xs mb-3">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A10.966 10.966 0 0112 15c2.4 0 4.62.86 6.328 2.304M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>

                            <span>{{ optional($event->organization)->name ?? 'Independent' }}</span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>

                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-3 pt-3 border-t border-slate-100">
                        <span class="text-lg font-black {{ $event->price == 0 ? 'text-emerald-600' : 'text-indigo-600' }}">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>

                        @if($soldOut)
                            <span class="ml-auto px-3 py-1.5 bg-slate-200 text-slate-600 rounded-full font-semibold text-xs">
                                Tiket Habis
                            </span>
                        @else
                            <a href="{{ route('events.show', $event) }}" class="ml-auto px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold transition hover:bg-indigo-600 hover:text-white">
                                Detail
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-slate-100 bg-slate-50 p-10 text-center">
                <p class="text-lg font-bold text-slate-900">Belum ada event yang tersedia.</p>
                <p class="mt-3 text-slate-500">Coba lagi nanti atau pilih kategori lain.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $events->links() }}
    </div>
</main>
@endsection