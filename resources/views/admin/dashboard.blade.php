@extends('layouts.admin')

@section('page_title', 'Dashboard Admin')
@section('page_subtitle', 'Pantau pertumbuhan pengguna, event, dan performa platform dari satu panel.')

@section('content')
<div class="space-y-8">
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <p class="text-sm font-semibold text-slate-500">Total Pengguna</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalUsers }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <p class="text-sm font-semibold text-slate-500">Organizer Terdaftar</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalOrganizers }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <p class="text-sm font-semibold text-slate-500">Event Aktif</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $activeEvents }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <p class="text-sm font-semibold text-slate-500">Pendapatan Platform</p>
            <p class="mt-3 text-3xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Grafik Pertumbuhan Pengguna</h2>
                    <p class="text-sm text-slate-500">Tren pendaftaran pengguna dalam 6 bulan terakhir.</p>
                </div>
            </div>
            <div class="mt-6 flex items-end gap-3 h-56">
                @foreach($monthlyUsers as $item)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full rounded-t-2xl bg-indigo-500" style="height: {{ max(18, $item['value'] * 20) }}px"></div>
                        <span class="text-xs font-semibold text-slate-500">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-slate-900">Ringkasan Platform</h2>
            <div class="mt-4 space-y-3">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Organisasi</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalOrganizations }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Partner</p>
                    <p class="text-2xl font-black text-slate-900">{{ $partnerCount }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Kategori Event</p>
                    <p class="text-2xl font-black text-slate-900">{{ $categoryCount }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-slate-900">Grafik Pertumbuhan Event</h2>
            <p class="text-sm text-slate-500">Jumlah event yang dibuat per bulan.</p>
            <div class="mt-6 flex items-end gap-3 h-56">
                @foreach($monthlyEvents as $item)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full rounded-t-2xl bg-emerald-500" style="height: {{ max(18, $item['value'] * 25) }}px"></div>
                        <span class="text-xs font-semibold text-slate-500">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-slate-900">Status Platform</h2>
            <div class="mt-4 space-y-3">
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Total Transaksi</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalTransactions }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Transaksi Pending</p>
                    <p class="text-2xl font-black text-amber-600">{{ $pendingTransactions }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Event Terjadwal</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
