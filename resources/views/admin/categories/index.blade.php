@extends('layouts.admin')

@section('page_title', 'Manajemen Kategori Event')
@section('page_subtitle', 'Kelola kategori event yang digunakan pada platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-black text-slate-900">Daftar Kategori Event</h2>
            <p class="text-sm text-slate-500">Kategori yang tersedia dapat digunakan untuk mengorganisir event.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white">+ Tambah Kategori</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($categories as $category)
            <div class="rounded-2xl border border-slate-200 p-4">
                <p class="font-semibold text-slate-900">{{ $category->name }}</p>
                <p class="mt-2 text-sm text-slate-500">Jumlah event: {{ $category->events_count }}</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="rounded-xl bg-indigo-50 px-3 py-2 text-sm font-semibold text-indigo-700">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                Belum ada kategori event.
            </div>
        @endforelse
    </div>
</div>
@endsection
