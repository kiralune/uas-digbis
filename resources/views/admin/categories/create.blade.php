@extends('layouts.admin')

@section('page_title', 'Tambah Kategori Event')
@section('page_subtitle', 'Tambahkan kategori baru yang bisa dipakai untuk event.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Tambah Kategori Event</h2>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            @error('name') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.categories.index') }}" class="rounded-2xl bg-slate-200 px-5 py-3 font-bold text-slate-700">Batal</a>
            <button type="submit" class="rounded-2xl bg-indigo-600 px-5 py-3 font-bold text-white">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection
