@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-20">
    <div class="grid gap-8 md:grid-cols-[1fr_330px] items-start">
        <section class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-3xl font-black">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-black">Halo, {{ auth()->user()->name }}</h1>
                        <p class="text-sm text-slate-500">Selamat datang di halaman profil Anda.</p>
                    </div>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-bold mb-2">Email</p>
                        <p class="font-semibold text-slate-900">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400 font-bold mb-2">Peran</p>
                        <p class="font-semibold text-slate-900">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <h2 class="text-2xl font-black mb-4">Pengaturan Akun</h2>
                <p class="text-slate-500 mb-6">Kelola informasi dasar akun dan akses cepat ke transaksi serta tiket Anda.</p>

                <div class="space-y-4">
                    <a href="{{ route('ticket', ['email' => auth()->user()->email]) }}" class="block rounded-3xl border border-slate-200 bg-slate-50 px-6 py-5 hover:border-indigo-300 hover:bg-indigo-50 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.25em] text-slate-400 font-bold">Transaksi & Tiketku</p>
                                <p class="font-semibold text-slate-900">Lihat semua pesanan dan tiket Anda</p>
                            </div>
                            <span class="text-indigo-600 font-bold">→</span>
                        </div>
                    </a>
                    <a href="{{ route('profile') }}" class="block rounded-3xl border border-indigo-600 bg-indigo-50 px-6 py-5 hover:bg-indigo-100 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.25em] text-indigo-600 font-bold">Pengaturan Akun</p>
                                <p class="font-semibold text-slate-900">Perbarui informasi profil Anda</p>
                            </div>
                            <span class="text-indigo-600 font-bold">→</span>
                        </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="block rounded-3xl border border-slate-200 bg-white px-6 py-5 shadow-sm">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center justify-between gap-4 text-slate-900 font-semibold hover:text-indigo-600 transition">
                            <span>
                                <p class="text-sm uppercase tracking-[0.25em] text-slate-400 font-bold">Keluar</p>
                                <p>Logout dari aplikasi</p>
                            </span>
                            <span class="text-indigo-600 font-bold">→</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <aside class="space-y-4">
            <div class="bg-indigo-600 text-white rounded-3xl p-8 shadow-xl">
                <p class="text-xs uppercase tracking-[0.25em] text-indigo-200 font-bold mb-3">Akun Aktif</p>
                <h2 class="text-2xl font-black mb-6">Detail Profil</h2>
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-slate-200 uppercase tracking-[0.2em] text-xs">Nama</dt>
                        <dd class="mt-1 font-semibold text-white">{{ auth()->user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-200 uppercase tracking-[0.2em] text-xs">Email</dt>
                        <dd class="mt-1 font-semibold text-white">{{ auth()->user()->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-200 uppercase tracking-[0.2em] text-xs">Role</dt>
                        <dd class="mt-1 font-semibold text-white">{{ ucfirst(auth()->user()->role) }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-black mb-4">Bantuan</h3>
                <p class="text-slate-500">Butuh bantuan? Hubungi support kami di <a href="mailto:support@eventtiket.com" class="text-indigo-600">support@eventtiket.com</a>.</p>
            </div>
        </aside>
    </div>
</main>
@endsection
