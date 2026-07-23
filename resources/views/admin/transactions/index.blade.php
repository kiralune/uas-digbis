@extends('layouts.admin')

@section('page_title', 'Manajemen Transaksi')
@section('page_subtitle', 'Pantau semua transaksi dan laporan pendapatan platform.')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Pendapatan</p>
            <p class="mt-3 text-2xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Transaksi Sukses</p>
            <p class="mt-3 text-2xl font-black text-slate-900">{{ $successfulTransactions }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Transaksi Pending</p>
            <p class="mt-3 text-2xl font-black text-amber-600">{{ $pendingTransactions }}</p>
        </div>
    </section>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h2 class="text-xl font-black text-slate-900">Semua Transaksi</h2>
            <p class="text-sm text-slate-500">Laporan pendapatan dan status pembayaran semua transaksi tersimpan di sini.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-left text-slate-500">
                        <th class="py-3 pr-4">Order ID</th>
                        <th class="py-3 pr-4">Customer</th>
                        <th class="py-3 pr-4">Event</th>
                        <th class="py-3 pr-4">Jumlah</th>
                        <th class="py-3 pr-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="border-b border-slate-100">
                            <td class="py-3 pr-4 font-semibold text-slate-900">{{ $transaction->order_id }}</td>
                            <td class="py-3 pr-4">{{ $transaction->customer_name }}</td>
                            <td class="py-3 pr-4">{{ $transaction->event?->title ?? '-' }}</td>
                            <td class="py-3 pr-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td class="py-3 pr-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $transaction->status === 'settlement' || $transaction->status === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($transaction->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
