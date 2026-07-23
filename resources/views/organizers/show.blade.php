@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-10">
    <section class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 md:p-12 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        <div class="md:col-span-1">
            <div class="w-28 h-28 rounded-[2rem] bg-indigo-100 flex items-center justify-center text-3xl font-black text-indigo-600 overflow-hidden">
                @if($partner->logo_url)
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                @endif
            </div>
        </div>
        <div class="md:col-span-2 space-y-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">Profil Penyelenggara</p>
                <h1 class="text-4xl font-black mt-2">{{ $partner->name }}</h1>
            </div>
            <div class="flex flex-wrap gap-4 text-slate-600">
                <div class="px-4 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-xs uppercase font-bold text-slate-400">Rata-rata Rating</p>
                    <p class="text-2xl font-black text-slate-900">{{ number_format($averageRating, 1) }}/5</p>
                </div>
                <div class="px-4 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-xs uppercase font-bold text-slate-400">Jumlah Review</p>
                    <p class="text-2xl font-black text-slate-900">{{ $reviewCount }}</p>
                </div>
            </div>
            <p class="text-slate-600 max-w-2xl">Rekam jejak penilaian di bawah ini membantu calon pembeli melihat kualitas pengalaman acara sebelumnya yang diselenggarakan oleh {{ $partner->name }}.</p>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
            <h2 class="text-2xl font-black mb-6">Testimoni Terbaru</h2>
            <div class="space-y-4">
                @forelse($partner->reviews->take(6) as $review)
                    <article class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center justify-between gap-4 mb-3">
                            <div>
                                <p class="font-bold text-slate-900">{{ $review->customer_name }}</p>
                                <p class="text-xs text-slate-400">{{ optional($review->submitted_at)->format('d M Y H:i') }}</p>
                            </div>
                            <div class="font-black text-indigo-600">{{ str_repeat('★', (int) $review->rating) }}</div>
                        </div>
                        <p class="text-slate-600">{{ $review->testimonial ?: 'Tidak ada testimoni tertulis.' }}</p>
                    </article>
                @empty
                    <p class="text-slate-500">Belum ada review yang masuk.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
            <h2 class="text-2xl font-black mb-6">Event yang Diselenggarakan</h2>
            <div class="space-y-4">
                @forelse($partner->events as $event)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="font-bold text-slate-900">{{ $event->title }}</p>
                        <p class="text-sm text-slate-500">{{ $event->date->format('d M Y') }} • {{ $event->location }}</p>
                        <a href="{{ route('events.show', $event) }}" class="inline-block mt-3 text-indigo-600 font-bold hover:underline">Lihat detail</a>
                    </div>
                @empty
                    <p class="text-slate-500">Belum ada event yang ditautkan ke penyelenggara ini.</p>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection