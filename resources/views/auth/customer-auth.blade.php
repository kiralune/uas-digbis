@extends('layouts.app')

@section('hideNav', true)

@section('content')
<main class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-6xl grid gap-8 lg:grid-cols-[1.1fr_1fr]">
        <section class="rounded-[2rem] bg-white p-10 shadow-2xl border border-slate-200 flex flex-col justify-center">
            <div class="max-w-xl">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-3xl bg-indigo-600 flex items-center justify-center text-white text-2xl font-black">A</div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] font-semibold text-indigo-600">AmikomEventHub</p>
                        <p class="text-slate-400 text-sm">New Era of Ticketing Partner</p>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">Nikmati kemudahan transaksi yang cepat, aman, dan tanpa ribet.</h1>
                <p class="mt-6 text-slate-500 leading-8">Bayar tiket dengan mudah, kelola event, dan dapatkan seluruh update penjualan dalam satu platform terpadu.</p>
                <div class="mt-10 grid gap-4">
                    <div class="rounded-3xl bg-indigo-50 p-6">
                        <h2 class="font-semibold text-indigo-700 text-lg">Mudah untuk event organizer</h2>
                        <p class="mt-2 text-slate-600">Kelola tiket dan laporan penjualan dengan cepat.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-6">
                        <h2 class="font-semibold text-slate-900 text-lg">Nyaman untuk penonton</h2>
                        <p class="mt-2 text-slate-600">Beli tiket tanpa repot dan checkout langsung.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] bg-white p-6 md:p-10 shadow-2xl border border-slate-200">
            <div class="rounded-3xl bg-slate-100 p-2 flex gap-2 mb-6">
                <button id="tab-login" type="button" class="flex-1 rounded-3xl px-5 py-3 font-semibold transition focus:outline-none">Masuk</button>
                <button id="tab-register" type="button" class="flex-1 rounded-3xl px-5 py-3 font-semibold transition focus:outline-none">Daftar</button>
            </div>

            <div id="panel-login" class="space-y-5">
                <a href="{{ url('/auth/google?redirect_to=' . route('home')) }}"
                   class="w-full inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white py-4 text-slate-900 font-semibold hover:bg-slate-50 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5">
                    Continue with Google
                </a>
                <form id="login-form" action="{{ route('login.post') }}" method="POST" class="space-y-5 mt-2">
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
                            class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Login dengan Email</button>
                </form>
            </div>

            <div id="panel-register" class="hidden space-y-5">
                <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('name')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('email')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <input type="password" name="password"
                                   class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                                   required>
                            @error('password')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                                   required>
                        </div>
                    </div>
                    <button type="submit"
                            class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Daftar dengan Email</button>
                </form>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-5 text-center text-slate-500 text-sm">
                Kamu penyelenggara event? <a id="partner-link" href="{{ route('organizer.login') }}" class="text-indigo-600 font-semibold">Masuk sebagai Event Partner</a>
            </div>
        </section>
    </div>
</main>

<script>
    const activeTab = @json($activeTab ?? 'login');
    const loginTab = document.getElementById('tab-login');
    const registerTab = document.getElementById('tab-register');
    const panelLogin = document.getElementById('panel-login');
    const panelRegister = document.getElementById('panel-register');
    const partnerLink = document.getElementById('partner-link');
    function setTab(tab) {
        if (tab === 'register') {
            loginTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-500 bg-transparent';
            registerTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-900 bg-white shadow-sm';
            panelLogin.classList.add('hidden');
            panelRegister.classList.remove('hidden');
            partnerLink.href = '{{ route('organizer.register') }}';
            partnerLink.textContent = 'Daftar Event Partner';
        } else {
            loginTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-900 bg-white shadow-sm';
            registerTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-500 bg-transparent';
            panelLogin.classList.remove('hidden');
            panelRegister.classList.add('hidden');
            partnerLink.href = '{{ route('organizer.login') }}';
            partnerLink.textContent = 'Masuk sebagai Event Partner';
        }
    }

    loginTab.addEventListener('click', () => setTab('login'));
    registerTab.addEventListener('click', () => setTab('register'));

    setTab(activeTab);
</script>
@endsection
