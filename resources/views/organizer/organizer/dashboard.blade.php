@extends('layouts.organizer')
@section('title', 'Dashboard Organizer')
@section('page_title', 'Dashboard Organizer')
@section('page_subtitle', 'Selamat datang kembali, ' . auth()->user()->name . ' — ' . optional(auth()->user()->organization)->name)

@section('content')
<div class="grid gap-6 mb-10">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 md:flex md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold uppercase tracking-[0.18em]">Organizer Dashboard</span>
                <h2 class="mt-4 text-3xl font-black text-slate-900">{{ optional(auth()->user()->organization)->name ?? 'Organisasi Anda' }}</h2>
                <p class="mt-2 text-slate-500 max-w-2xl">Ringkasan performa event, transaksi, dan tiket aktif untuk organisasi Anda saja.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('organizer.events.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">Kelola Event</a>
                <a href="{{ route('organizer.transactions.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Lihat Transaksi</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Total Pendapatan</p>
                    <h3 class="mt-3 text-3xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Tiket Terjual</p>
                    <h3 class="mt-3 text-3xl font-black text-slate-900">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Event Aktif</p>
                    <h3 class="mt-3 text-3xl font-black text-slate-900">{{ $activeEvents }} Event</h3>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Pesanan Pending</p>
                    <h3 class="mt-3 text-3xl font-black text-slate-900">{{ $pendingOrders }} Pesanan</h3>
                </div>
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr] mb-8">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="font-black text-xl">Analitik Pendapatan</h3>
                    <p class="mt-2 text-slate-500 text-sm">Tren pendapatan 6 bulan terakhir dari transaksi berhasil.</p>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 font-semibold text-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Tingkat keberhasilan {{ $successRate }}%
                </div>
            </div>
        </div>
        <div class="p-8">
            @if(count($monthlyRevenue) > 0)
                <div class="flex items-end gap-4 h-64">
                    @foreach($monthlyRevenue as $item)
                        @php $height = $maxMonthlyRevenue > 0 ? max(10, round(($item['value'] / $maxMonthlyRevenue) * 100)) : 10; @endphp
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full flex items-end justify-center h-48 rounded-2xl bg-slate-50 p-2">
                                <div class="w-full rounded-2xl bg-gradient-to-t from-indigo-600 to-cyan-400" style="height: {{ $height }}%"></div>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $item['label'] }}</p>
                                <p class="mt-1 text-sm font-black text-slate-700">Rp {{ number_format($item['value'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex h-64 items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50 text-slate-500">
                    Belum ada transaksi berhasil untuk dianalisis.
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b">
            <h3 class="font-black text-xl">Ringkasan Kinerja</h3>
            <p class="mt-2 text-slate-500 text-sm">Snapshot cepat performa organisasi Anda.</p>
        </div>
        <div class="p-8 space-y-5">
            <div class="rounded-2xl bg-indigo-50 p-5">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-600">Pendapatan Bulan Ini</p>
                <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format(end($monthlyRevenue)['value'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl bg-emerald-50 p-5">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Rata-rata Per Bulan</p>
                <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format($averageMonthlyRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl bg-amber-50 p-5">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-600">Transaksi Sukses</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $totalSuccessfulTransactions }} / {{ $totalTransactions }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="font-black text-xl">Transaksi Terakhir</h3>
            <p class="mt-2 text-slate-500 text-sm">Menampilkan 5 transaksi terbaru dari organisasi Anda.</p>
        </div>
        <a href="{{ route('organizer.transactions.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-8 py-4 w-1/4">Pembeli</th>
                    <th class="px-8 py-4 w-1/4">Event</th>
                    <th class="px-8 py-4 w-[10%]">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">{{ $trx->created_at->format('d M y - H:i') }}<br><span class="text-xs text-slate-400">{{ $trx->order_id }}</span></td>
                    <td class="px-8 py-6">
                        <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @if($trx->status === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                        @elseif($trx->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
