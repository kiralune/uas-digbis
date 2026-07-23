@extends('layouts.admin')

@section('page_title', 'Manajemen Partner')
@section('page_subtitle', 'Kelola daftar partner yang mendukung platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Daftar Partner</h2>
        <p class="text-sm text-slate-500">Semua partner yang terdaftar pada platform dapat dilihat di sini.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($partners as $partner)
            <div class="rounded-2xl border border-slate-200 p-4">
                <p class="font-semibold text-slate-900">{{ $partner->name }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $partner->logo_url ?? 'Logo belum tersedia' }}</p>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                Belum ada partner yang terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
