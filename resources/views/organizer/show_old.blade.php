@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <section class="grid gap-8 lg:grid-cols-[1.2fr_1fr] items-start">
        <div class="rounded-[2.5rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col items-center text-center gap-6">
                <div class="w-28 h-28 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border-4 border-indigo-100">
                    @if($organizer->logo_url)
                        <img src="{{ $organizer->logo_url }}" alt="{{ $organizer->name }}" class="w-full h-full object-cover" />
                    @else
                        <span class="text-3xl font-bold text-indigo-600">{{ strtoupper(substr($organizer->name, 0, 2)) }}</span>
                    @endif
                </div>

                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-indigo-600 font-semibold">Organizer</p>
                    <h1 class="mt-3 text-4xl font-black text-slate-900">{{ $organizer->name }}</h1>
                    <p class="mt-3 text-slate-600">Profil publik organizer event, menampilkan portofolio acara dan ulasan peserta.</p>
                </div>
            </div>

            <div class="grid gap-4 mt-10 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Total Event</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $eventCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Rating Rata-rata</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $averageRating ?: 'Belum ada' }} <span class="text-base font-medium text-slate-500">/ 5</span></p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Review</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $reviewCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Tiket Terjual</p>
                    <p class="mt-3 text-3xl font-black text-slate-900">{{ $ticketsSold }}</p>
                </div>
            </div>

            <div class="mt-10 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-black text-slate-900">Tentang Organizer</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    Halaman ini menunjukkan rekam jejak event, kualitas layanan, dan testimoni peserta untuk membantu calon pembeli memilih acara dari organizer terpercaya.
                </p>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-indigo-50 p-5">
                        <p class="text-sm uppercase tracking-[0.3em] text-indigo-600">Event Mendatang</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">{{ $upcomingEventsCount }}</p>
                    </div>
                    <div class="rounded-3xl bg-indigo-50 p-5">
                        <p class="text-sm uppercase tracking-[0.3em] text-indigo-600">Event Selesai</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">{{ $pastEventsCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-10 xl:grid-cols-[2fr_1fr]">
        <div class="rounded-[2.5rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-indigo-600 font-semibold">Event Unggulan</p>
                    <h2 class="mt-3 text-2xl font-black text-slate-900">Event yang Diunggah</h2>
                </div>
                <span class="rounded-full bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700">{{ $eventCount }} Event</span>
            </div>

            <div class="mt-8 space-y-5">
                @forelse($organizer->events as $event)
                    <article class="rounded-3xl border border-slate-200 p-6 hover:shadow-lg transition">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl font-black text-slate-900">{{ $event->title }}</h3>
                                <p class="mt-2 text-sm text-slate-500">{{ $event->category?->name ?? 'Kategori tidak tersedia' }} • {{ optional($event->date)->format('d M Y') }}</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="mt-4 text-slate-600">{{ Illuminate\Support\Str::limit($event->description, 150) }}</p>
                    </article>
                @empty
                    <div class="rounded-3xl border border-slate-200 p-8 text-slate-500">Belum ada event yang diunggah oleh organizer ini.</div>
                @endforelse
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-[2.5rem] border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-black text-slate-900">Ulasan Peserta</h2>
                <p class="mt-3 text-slate-600">Ulasan terbaru menunjukkan pengalaman peserta dan tingkat kepuasan event.</p>

                <div class="mt-8 space-y-4">
                    @forelse($organizer->reviews as $review)
                        <div class="rounded-3xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $review->customer_name }}</p>
                                    <p class="text-sm text-slate-500">{{ optional($review->submitted_at)->format('d M Y') }}</p>
                                </div>
                                <div class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">{{ $review->rating }} / 5</div>
                            </div>
                            <p class="mt-4 text-slate-600">{{ $review->testimonial }}</p>
                            <p class="mt-4 text-sm text-slate-400">Event: {{ $review->event?->title ?? 'Tidak tersedia' }}</p>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-slate-200 p-8 text-slate-500">Belum ada review dari peserta.</div>
                    @endforelse
                </div>
            </div>

            
        </aside>
    </section>
</main>
@endsection
