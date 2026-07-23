@extends('layouts.admin')

@section('page_title', 'Tambah Partner')
@section('page_subtitle', 'Tambahkan partner baru untuk mendukung platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Tambah Partner Baru</h2>
    </div>

    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Partner</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            @error('name') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Logo Partner</label>
            <input type="file" name="logo" accept="image/*" class="w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            @error('logo') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.partners.index') }}" class="rounded-2xl bg-slate-200 px-5 py-3 font-bold text-slate-700">Batal</a>
            <button type="submit" class="rounded-2xl bg-indigo-600 px-5 py-3 font-bold text-white">Simpan Partner</button>
        </div>
    </form>
</div>
@endsection
