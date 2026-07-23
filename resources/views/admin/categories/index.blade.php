@extends('layouts.admin')

@section('page_title', 'Manajemen Kategori Event')
@section('page_subtitle', 'Kelola kategori event yang digunakan pada platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Daftar Kategori Event</h2>
        <p class="text-sm text-slate-500">Kategori yang tersedia dapat digunakan untuk mengorganisir event.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($categories as $category)
            <div class="rounded-2xl border border-slate-200 p-4">
                <p class="font-semibold text-slate-900">{{ $category->name }}</p>
                <p class="mt-2 text-sm text-slate-500">Jumlah event: {{ $category->events_count }}</p>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                Belum ada kategori event.
            </div>
        @endforelse
    </div>
</div>
@endsection
