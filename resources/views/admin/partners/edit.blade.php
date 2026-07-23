@extends('layouts.admin')

@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah data partner platform.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Edit Partner</h2>
    </div>

    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Partner</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            @error('name') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Logo Partner</label>
            @if($partner->logo_url)
                <div class="mb-3 rounded-2xl border border-slate-200 p-3">
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-20 w-20 object-contain rounded-xl">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full rounded-2xl border border-slate-200 px-4 py-3">
            @error('logo') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.partners.index') }}" class="rounded-2xl bg-slate-200 px-5 py-3 font-bold text-slate-700">Batal</a>
            <button type="submit" class="rounded-2xl bg-indigo-600 px-5 py-3 font-bold text-white">Update Partner</button>
        </div>
    </form>
</div>
@endsection
