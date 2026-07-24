@extends('layouts.organizer')

@section('page_title', 'Edit Profil Organizer')
@section('page_subtitle', 'Kelola informasi organisasi dan logo Anda')

@section('content')
<div class="grid grid-cols-1 gap-8">
    <div class="rounded-[2.5rem] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Informasi Profil</h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                <p class="font-semibold text-red-900">Terjadi kesalahan:</p>
                <ul class="mt-3 space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5">
                <p class="font-semibold text-green-900">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Logo Section -->
            <div class="rounded-2xl border border-slate-200 p-6">
                <label class="block mb-4">
                    <span class="text-lg font-semibold text-slate-900">Logo Organizer</span>
                    <p class="mt-1 text-sm text-slate-500">Ukuran file maksimal 2MB (JPG, PNG, GIF)</p>
                </label>

                <div class="flex flex-col gap-6 sm:flex-row sm:items-end">
                    <!-- Preview -->
                    <div class="flex items-center justify-center">
                        <div class="w-32 h-32 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden">
                            @if ($organizer->logo_url)
                                <img src="{{ $organizer->logo_url }}" alt="{{ $organizer->name }}"
                                    class="w-full h-full object-cover" id="logoPreview" />
                            @else
                                <span class="text-4xl font-bold text-slate-400">{{ strtoupper(substr($organizer->name, 0, 2)) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1">
                        <input type="file" name="logo_url" id="logoInput" accept="image/*"
                            class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100" />
                    </div>
                </div>
            </div>

            <!-- Name Section -->
            <div class="rounded-2xl border border-slate-200 p-6">
                <label for="name" class="block mb-3">
                    <span class="text-lg font-semibold text-slate-900">Nama Organizer</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $organizer->name) }}"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                    placeholder="Masukkan nama organizer" required />
            </div>

            <!-- Description Section -->
            <div class="rounded-2xl border border-slate-200 p-6">
                <label for="description" class="block mb-3">
                    <span class="text-lg font-semibold text-slate-900">Deskripsi Organizer</span>
                    <p class="mt-1 text-sm text-slate-500">Jelaskan tentang organisasi Anda (maksimal 1000 karakter)</p>
                </label>
                <textarea id="description" name="description" rows="5"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                    placeholder="Tuliskan deskripsi organisasi Anda di sini...">{{ old('description', $organizer->description) }}</textarea>
                <p class="mt-2 text-xs text-slate-500"><span id="charCount">{{ strlen(old('description', $organizer->description ?? '')) }}</span>/1000</p>
            </div>

            <!-- Slug Info (Read-only) -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <label for="slug" class="block mb-3">
                    <span class="text-lg font-semibold text-slate-900">URL Slug</span>
                    <p class="mt-1 text-sm text-slate-500">Otomatis berdasarkan nama organizer</p>
                </label>
                <input type="text" id="slug" value="{{ $organizer->slug }}" disabled
                    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-4 py-3 text-slate-600 cursor-not-allowed" />
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('organizer.dashboard') }}"
                    class="rounded-lg border border-slate-300 px-6 py-3 font-semibold text-slate-900 hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('logoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const preview = document.getElementById('logoPreview');
                preview.src = event.target.result;
                preview.parentElement.innerHTML = `<img src="${event.target.result}" alt="Preview" class="w-full h-full object-cover" />`;
            };
            reader.readAsDataURL(file);
        }
    });

    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    function generateSlug(value) {
        return value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }

    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function () {
            slugInput.value = generateSlug(this.value);
        });
    }

    // Character counter for description
    const descriptionInput = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    descriptionInput.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
</script>
@endsection
