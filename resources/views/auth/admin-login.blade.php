@extends('layouts.app')

@section('hideNav', true)

@section('content')
<div class="min-h-screen bg-slate-950 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md rounded-3xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-400">AmikomEventHub</p>
            <h1 class="mt-3 text-3xl font-black text-white">Login Admin</h1>
            <p class="mt-2 text-sm text-slate-400">Masuk ke dashboard admin untuk mengelola platform.</p>
        </div>

        <form method="POST" action="{{ route('admin_auth.login.post') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-300" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-white outline-none ring-0 focus:border-indigo-500" placeholder="admin@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-300" for="password">Password</label>
                <input id="password" type="password" name="password" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-white outline-none ring-0 focus:border-indigo-500" placeholder="Masukkan password">
            </div>

            <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-3 font-bold text-white transition hover:bg-indigo-500">Masuk ke Dashboard Admin</button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-400">
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Kembali ke login pengguna</a>
        </div>
    </div>
</div>
@endsection
