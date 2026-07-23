@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-10">
    <section class="bg-gradient-to-br from-indigo-600 to-slate-900 text-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl overflow-hidden relative">
        <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 rounded-full bg-cyan-400/10 blur-2xl"></div>
        <div class="relative max-w-3xl space-y-4">
            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-200">Review Saya</p>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">Semua review yang sudah Anda kirim setelah mengikuti event.</h1>
            <p class="text-indigo-100 text-lg max-w-2xl">Lihat kembali ulasan Anda untuk event yang sudah selesai, lengkap dengan rating dan komentar.</p>
        </div>
    </section>

    <section class="space-y-6">
        @if($reviews->isEmpty())
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">
                <p class="font-bold text-slate-900">Belum ada review yang tersimpan.</p>
                <p class="text-slate-500 mt-2">Review Anda akan muncul di sini setelah mengikuti event dan mengisi ulasan.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($reviews as $review)
                    <article class="bg-white rounded-[2.25rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-0">
                            <div class="bg-slate-950 text-white lg:border-r border-slate-800 p-8">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-300 font-black">Event</p>
                                <h3 class="mt-4 text-2xl font-black">{{ $review->event->title }}</h3>
                                <p class="mt-2 text-slate-400">{{ optional($review->event->partner)->name ?? 'Independent' }}</p>
                            </div>
                            <div class="lg:col-span-3 p-8 space-y-6">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Tanggal Acara</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $review->event->date->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-widest font-black text-slate-400">Tanggal Review</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ optional($review->submitted_at)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="rounded-[1.75rem] border border-slate-100 bg-slate-50 p-6">
                                    <p class="text-xs uppercase tracking-widest font-black text-slate-400">Rating</p>
                                    <p class="mt-2 text-3xl font-black text-indigo-600">{{ str_repeat('★', (int) $review->rating) }}</p>
                                </div>

                                <div class="rounded-[1.75rem] border border-slate-100 bg-white p-6">
                                    <p class="text-xs uppercase tracking-widest font-black text-slate-400">Apa yang Anda tulis</p>
                                    <p class="mt-4 text-slate-700">{{ $review->testimonial ?: 'Tidak ada komentar tambahan.' }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</main>
@endsection
