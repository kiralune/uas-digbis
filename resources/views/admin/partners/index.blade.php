@extends('layouts.admin')

@section('page_title', 'Manajemen Partner')
@section('page_subtitle', 'Kelola daftar partner yang mendukung platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-black text-slate-900">Daftar Partner</h2>
            <p class="text-sm text-slate-500">Semua partner yang terdaftar pada platform dapat dilihat di sini.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="inline-flex rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white">+ Tambah Partner</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($partners as $partner)
            <div class="rounded-2xl border border-slate-200 p-4">
                <div class="mb-3 flex items-center gap-3">
                    @if($partner->logo_url)
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-14 w-14 rounded-xl object-contain border border-slate-200 bg-white">
                    @endif
                    <p class="font-semibold text-slate-900">{{ $partner->name }}</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.partners.edit', $partner->id) }}" class="rounded-xl bg-indigo-50 px-3 py-2 text-sm font-semibold text-indigo-700">Edit</a>
                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus partner ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                Belum ada partner yang terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
