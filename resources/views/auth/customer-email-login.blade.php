@extends('layouts.app')

@section('content')
<main class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-50">
    <div class="max-w-3xl w-full rounded-[2rem] bg-white p-10 shadow-2xl border border-slate-200">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-black text-slate-900">Masuk dengan Email</h1>
            <p class="mt-3 text-slate-500">Masuk atau daftar dengan menggunakan alamat email Anda untuk melanjutkan pemesanan tiket.</p>
        </div>

        <form action="#" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                <input type="email" name="email" placeholder="nama@contoh.com"
                       class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                       class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100" required>
            </div>
            <button type="submit"
                    class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Masuk</button>
        </form>

        <div class="mt-8 text-center text-slate-500">
            Belum punya akun? <a href="#" class="text-indigo-600 font-semibold">Daftar sekarang</a>
        </div>
    </div>
</main>
@endsection
