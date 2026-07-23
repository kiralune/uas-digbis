@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-16">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden mb-10">
        <div class="p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-indigo-600 font-bold mb-3">Profil Penyelenggara</p>
                    <h1 class="text-4xl font-black text-slate-900">{{ $organization->name }}</h1>
                    <p class="mt-3 text-slate-500 max-w-2xl">Lihat semua event yang diselenggarakan oleh organisasi ini.</p>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-50 rounded-3xl p-6">
                    <p class="text-slate-500 uppercase tracking-[0.2em] text-xs mb-3">Status</p>
                    <p class="text-2xl font-black text-slate-900">{{ ucfirst($organization->status) }}</p>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <p class="text-slate-500 uppercase tracking-[0.2em] text-xs mb-3">Jumlah Event Aktif</p>
                    <p class="text-2xl font-black text-slate-900">{{ $events->count() }}</p>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <p class="text-slate-500 uppercase tracking-[0.2em] text-xs mb-3">Total Tiket Tersisa</p>
                    <p class="text-2xl font-black text-slate-900">{{ $events->sum('stock') }}</p>
                </div>
            </div>
        </div>
    </div>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl transition">
                <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="w-full h-72 object-cover">
                <div class="p-6">
                    <span class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-[0.2em]">{{ $event->category->name }}</span>
                    <h2 class="mt-4 text-2xl font-black text-slate-900">{{ $event->title }}</h2>
                    <p class="mt-3 text-slate-500 text-sm">{{ Str::limit($event->description, 100) }}</p>
                    <div class="mt-4 flex items-center justify-between gap-4">
                        <span class="font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ route('events.show', $event->id) }}" class="inline-flex px-4 py-2 bg-indigo-600 text-white rounded-2xl font-semibold">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-100 shadow-sm p-10 text-center text-slate-500">
                Organisasi ini belum memiliki event aktif.
            </div>
        @endforelse
    </section>
</main>
@endsection
