@extends('layouts.app')

@section('content')
    @php
        $initials = strtoupper(substr($organizer->name ?? 'O', 0, 2));
        $ratingLabel = $averageRating ? number_format($averageRating, 1) : 'Belum ada';
    @endphp

    <main class="mx-auto max-w-7xl space-y-10 px-6 py-10 md:py-14">
        {{-- Hero profil organizer --}}
        <section class="relative overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-8 text-white shadow-xl md:px-10 md:py-12">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-700 via-slate-950 to-slate-950"></div>
            <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-indigo-400/20 blur-3xl"></div>
            <div class="absolute -bottom-28 left-1/3 h-64 w-64 rounded-full bg-blue-400/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                    <div class="shrink-0">
                        <div class="h-28 w-28 overflow-hidden rounded-3xl border-4 border-white/20 bg-white shadow-2xl md:h-32 md:w-32">
                            @if($organizer->logo_url)
                                <img src="{{ $organizer->logo_url }}" alt="Logo {{ $organizer->name }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-indigo-100 text-3xl font-black text-indigo-700">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="max-w-2xl">
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-300/30 bg-emerald-400/10 px-3 py-1.5 text-xs font-bold text-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            Organizer aktif di AmikomEventHub
                        </div>

                        <h1 class="text-3xl font-black tracking-tight md:text-5xl">
                            {{ $organizer->name }}
                        </h1>

                        <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-300 md:text-base">
                            {{ $organizer->description ?: 'Organizer yang menghadirkan pengalaman event terbaik untuk setiap peserta.' }}
                        </p>
                    </div>
                </div>

                <a href="#event-organizer"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3.5 text-sm font-bold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-indigo-50">
                    Lihat Event
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6" />
                    </svg>
                </a>
            </div>
        </section>

        {{-- Bukti sosial --}}
        <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $eventCount }}</p>
                        <p class="text-xs font-medium text-slate-500">Event diselenggarakan</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $ratingLabel }}</p>
                        <p class="text-xs font-medium text-slate-500">Rating dari peserta</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $reviewCount }}</p>
                        <p class="text-xs font-medium text-slate-500">Ulasan peserta</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $ticketsSold }}</p>
                        <p class="text-xs font-medium text-slate-500">Tiket telah terjual</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">
            {{-- Daftar event --}}
            <div id="event-organizer" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-bold text-indigo-600">EVENT DARI ORGANIZER INI</p>
                        <h2 class="mt-1 text-2xl font-black text-slate-900">Pilih event yang Anda sukai</h2>
                        <p class="mt-2 text-sm text-slate-500">Lihat detail event, jadwal, dan pilihan tiket sebelum membeli.</p>
                    </div>

                    <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">
                        {{ $eventCount }} event tersedia
                    </span>
                </div>

                <div class="grid gap-4">
                    @forelse($organizer->events as $event)
                        @php
                            $posterUrl = $event->poster_path
                                ? (str_starts_with($event->poster_path, 'http')
                                    ? $event->poster_path
                                    : asset('storage/' . ltrim($event->poster_path, '/')))
                                : asset('assets/concert.png');
                        @endphp

                        <a href="{{ route('events.show', $event) }}"
                            class="group overflow-hidden rounded-2xl border border-slate-200 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-lg">
                            <div class="flex flex-col sm:flex-row">
                                <div class="h-44 shrink-0 overflow-hidden bg-slate-100 sm:h-auto sm:w-44">
                                    <img src="{{ $posterUrl }}" alt="{{ $event->title }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>

                                <div class="flex flex-1 flex-col p-5">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700">
                                                {{ $event->category?->name ?? 'Event' }}
                                            </span>

                                            <h3 class="mt-3 text-lg font-black text-slate-900 transition group-hover:text-indigo-600">
                                                {{ $event->title }}
                                            </h3>
                                        </div>

                                        <span class="rounded-xl bg-slate-900 px-3 py-1.5 text-sm font-bold text-white">
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-500">
                                        {{ $event->description }}
                                    </p>

                                    <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600">
                                            <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ optional($event->date)->format('d M Y') ?? 'Tanggal menyusul' }}
                                        </span>

                                        <span class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600">
                                            Detail event
                                            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-16 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 font-bold text-slate-900">Belum ada event tersedia</h3>
                            <p class="mt-1 text-sm text-slate-500">Silakan kembali lagi untuk melihat event terbaru dari organizer ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="space-y-6">
                {{-- Reputasi organizer --}}
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-indigo-600">REPUTASI</p>
                            <h2 class="mt-1 text-xl font-black text-slate-900">Kepercayaan peserta</h2>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-slate-50 p-5">
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-4xl font-black text-slate-900">{{ $ratingLabel }}</p>
                                <p class="mt-1 text-sm text-slate-500">dari skala 5</p>
                            </div>
                            <p class="text-sm font-bold text-slate-700">{{ $reviewCount }} ulasan</p>
                        </div>

                        <div class="mt-4 flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 {{ $averageRating && $i <= round($averageRating) ? 'text-amber-400' : 'text-slate-200' }}"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <div class="mt-5 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Event mendatang</span>
                            <span class="font-bold text-slate-900">{{ $upcomingEventsCount }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Event telah selesai</span>
                            <span class="font-bold text-slate-900">{{ $pastEventsCount }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Tiket telah terjual</span>
                            <span class="font-bold text-slate-900">{{ $ticketsSold }}</span>
                        </div>
                    </div>
                </div>

                {{-- Ulasan --}}
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-indigo-600">TESTIMONI PESERTA</p>
                            <h2 class="mt-1 text-xl font-black text-slate-900">Ulasan terbaru</h2>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">
                            {{ $reviewCount }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse($organizer->reviews->take(3) as $review)
                            <article class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-bold text-slate-900">{{ $review->customer_name }}</p>

                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                        <span class="text-sm font-bold text-slate-700">{{ $review->rating }}/5</span>
                                    </div>
                                </div>

                                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                    {{ $review->testimonial ?: 'Peserta memberikan penilaian untuk event ini.' }}
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    {{ $review->event?->title ?? 'Event organizer' }} ·
                                    {{ optional($review->submitted_at)->format('d M Y') }}
                                </p>
                            </article>
                        @empty
                            <div class="rounded-2xl bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm font-medium text-slate-600">Belum ada ulasan dari peserta.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($reviewCount > 3)
                        <p class="mt-5 border-t border-slate-100 pt-4 text-center text-xs font-semibold text-slate-500">
                            +{{ $reviewCount - 3 }} ulasan lainnya
                        </p>
                    @endif
                </div>
            </aside>
        </section>
    </main>
@endsection