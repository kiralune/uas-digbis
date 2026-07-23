@extends('layouts.app')

@section('hideNav', true)

@section('content')
<main class="min-h-screen flex items-center justify-center px-4 py-10 bg-slate-50">
    <div class="max-w-4xl w-full grid grid-cols-1 gap-8">
        <section class="rounded-[2rem] bg-white p-10 shadow-2xl border border-slate-200">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">Masuk ke AmikomEventHub</h1>
                <p class="mt-4 text-slate-500 text-lg leading-8">Gunakan akun Anda untuk membeli tiket dan mengatur pesanan dengan cepat.</p>
            </div>

            <div class="mt-10 space-y-5">
                <a href="{{ url('/auth/google?redirect_to=' . route('home')) }}"
                   class="flex items-center justify-center gap-3 w-full rounded-2xl border border-slate-200 py-4 text-slate-900 font-semibold hover:bg-slate-50 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5">
                    Masuk dengan Google
                </a>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('email')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('password')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit"
                            class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Masuk dengan Email</button>
                </form>

                <div class="grid gap-4 mt-4">
                    <a href="{{ route('organizer_auth.login') }}"
                       class="flex items-center justify-center gap-3 w-full rounded-2xl border border-indigo-600 bg-indigo-50 py-4 text-indigo-700 font-semibold hover:bg-indigo-100 transition">
                        Masuk sebagai Organizer
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center gap-3 w-full rounded-2xl bg-indigo-600 py-4 text-white font-semibold hover:bg-indigo-700 transition">
                        Daftar Akun Baru
                    </a>
                </div>

                <div class="text-center text-slate-500 mt-4 text-sm">
                    Jika Anda penyelenggara event, gunakan tombol Organizer di atas.
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
