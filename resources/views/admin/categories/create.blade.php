@extends('layouts.admin')
@section('title', 'Tambah Kategori - Admin')
@section('page_title', 'Tambah Kategori')
@section('page_subtitle', 'Buat kategori event baru untuk AmikomEventHub Anda.')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition @error('name') border-rose-500 @enderror" placeholder="Misal: Teknologi, Bisnis, dll">
                @error('name')
                <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 active:scale-95 transition">
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-lg font-bold hover:bg-slate-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
