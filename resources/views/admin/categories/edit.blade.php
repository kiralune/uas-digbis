@extends('layouts.admin')

@section('page_title', 'Edit Kategori Event')
@section('page_subtitle', 'Ubah nama kategori event global.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Edit Kategori Event</h2>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            @error('name') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.categories.index') }}" class="rounded-2xl bg-slate-200 px-5 py-3 font-bold text-slate-700">Batal</a>
            <button type="submit" class="rounded-2xl bg-indigo-600 px-5 py-3 font-bold text-white">Update Kategori</button>
        </div>
    </form>
</div>
@endsection
