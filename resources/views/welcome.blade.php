@extends('layouts.app')

@section('content')

<style>
    html {
        scroll-behavior: smooth;
    }

    .partner-track {
        animation: partner-slide 28s linear infinite;
    }

    @keyframes partner-slide {
        from {
            transform: translateX(0%);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .partner-track {
            animation: none;
        }
    }
</style>

   <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
                Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
                Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div
                class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <img src="assets/concert.png" alt="Concert"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Blok Navigasi Filter Kategori -->
   <div class="mb-8 flex gap-4 justify-center">
        <!-- Rujukan awal navigasi bebas bawaan -->
        <a href="/" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-black transition">Semua Kategori</a>
    <!-- Melakukan iterasi nama Tab Kategori dinamis saat jumlah data bertambah  -->
    @foreach($categories as $cat)
                <a href="/?category={{ $cat->slug }}" 
                class="px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded shadow-sm transition">
                    {{ $cat->name }}
                </a>
            @endforeach
    </div>

    <!-- Events Grid -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-20 scroll-mt-8">
        <!-- Zona Menampilkan Grid List Event -->
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
        @php $soldOut = (int) $event->stock <= 0; @endphp
        <div
            class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden {{ $soldOut ? 'opacity-80 grayscale' : '' }}">
            <div class="relative overflow-hidden aspect-[3/4]">
                <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 {{ $soldOut ? 'blur-[2px] grayscale saturate-50' : 'group-hover:scale-110' }}">
                @if($soldOut)
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="px-4 py-2 rounded-full bg-rose-600 text-white font-black shadow-lg">Habis</span>
                    </div>
                @endif
                <div
                    class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                    {{ $event->category->name }}</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                <div class="flex flex-col gap-2 text-slate-500 text-sm mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10.966 10.966 0 0112 15c2.4 0 4.62.86 6.328 2.304M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Penyelenggara: {{ $event->organization->name ?? 'Independent' }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t">
                    <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    <a href="{{ $soldOut ? '#' : route('events.show', $event->id) }}" class="px-5 py-2 rounded-xl font-bold transition {{ $soldOut ? 'bg-slate-200 text-slate-500 cursor-not-allowed pointer-events-none' : 'bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white' }}">{{ $soldOut ? 'Habis' : 'Lihat Detail' }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Partners Section -->
    <section id="partner" class="max-w-7xl mx-auto px-6 py-20 scroll-mt-8 bg-gradient-to-b from-slate-50 to-white rounded-3xl">
    <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-black mb-4">
            Dipercaya oleh <span class="text-indigo-600">Partner Terkemuka</span>
        </h2>

        <p class="text-lg text-slate-500 max-w-2xl mx-auto">
            AmikomEventHub berkolaborasi dengan berbagai perusahaan dan organisasi terkemuka untuk memberikan pengalaman event terbaik.
        </p>
    </div>

        @if($partners->count() > 0)
        <div class="overflow-hidden">
            <div class="partner-track flex w-max gap-6 py-2">
                @foreach($partners as $partner)
                    <div class="group p-6 rounded-2xl border border-slate-200 hover:border-indigo-400 hover:shadow-lg bg-white transition-all duration-300 flex items-center justify-center h-40 w-56 shrink-0">
                        <img src="{{ $partner->logo_url }}"
                            alt="{{ $partner->name }}"
                            title="{{ $partner->name }}"
                            class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-300">
                    </div>
                @endforeach

                {{-- Duplikat logo agar animasi berulang tanpa jeda --}}
                @foreach($partners as $partner)
                    <div aria-hidden="true"
                        class="group p-6 rounded-2xl border border-slate-200 hover:border-indigo-400 hover:shadow-lg bg-white transition-all duration-300 flex items-center justify-center h-40 w-56 shrink-0">
                        <img src="{{ $partner->logo_url }}"
                            alt=""
                            class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-300">
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-slate-100 rounded-2xl">
            <p class="text-slate-500">Belum ada partner yang terdaftar.</p>
        </div>
    @endif
    </section>

    <!-- Kategori Section -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Jenis-Jenis <span class="text-indigo-600">Event</span>
            </h2>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">
                Kami menyediakan berbagai kategori event untuk memenuhi semua kebutuhan Anda.
            </p>
        </div>

        @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="/?category={{ $category->slug }}" 
                class="group p-8 rounded-2xl border-2 border-slate-200 hover:border-indigo-600 bg-white hover:bg-indigo-50 transition-all duration-300 text-center">
                <div class="text-4xl mb-4 opacity-60 group-hover:opacity-100 transition">📁</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition">{{ $category->name }}</h3>
                <p class="text-sm text-slate-500">Jelajahi berbagai event di kategori ini</p>
                <div class="mt-4 inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold opacity-0 group-hover:opacity-100 transition">
                    Lihat Event →
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-slate-100 rounded-2xl">
            <p class="text-slate-500">Belum ada kategori yang tersedia.</p>
        </div>
        @endif
    </section>

@endsection