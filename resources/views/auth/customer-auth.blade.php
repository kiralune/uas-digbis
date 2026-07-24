@extends('layouts.app')

@section('hideNav', true)
@section('hideFooter', true)

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

                <div class="flex items-center gap-4 py-1 text-sm font-medium text-slate-400">
                    <span class="h-px flex-1 bg-slate-200"></span>
                    <span>atau</span>
                    <span class="h-px flex-1 bg-slate-200"></span>
                </div>
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
                    <button id="login-submit-btn" type="submit"
                            class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Login dengan Email</button>
                </form>
            </div>

            <div id="panel-register" class="hidden space-y-5">
                <a href="{{ url('/auth/google?redirect_to=' . route('home')) }}"
                   class="w-full inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white py-4 text-slate-900 font-semibold hover:bg-slate-50 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5">
                    Daftar dengan Google
                </a>

                <div class="flex items-center gap-4 py-1 text-sm font-medium text-slate-400">
                    <span class="h-px flex-1 bg-slate-200"></span>
                    <span>atau</span>
                    <span class="h-px flex-1 bg-slate-200"></span>
                </div>

                <form action="{{ route('register.post') }}" method="POST" class="space-y-5 mt-2">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('name')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('email')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxx"
                               class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                               required>
                        @error('phone')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                                   required>
                            @error('password')<p class="mt-2 text-sm text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                   class="w-full rounded-2xl border border-slate-200 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                                   required>
                        </div>
                    </div>
                    <button id="register-submit-btn" type="submit"
                            class="w-full rounded-2xl bg-indigo-600 py-4 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Daftar dengan Email</button>
                </form>
            </div>

            <div class="pt-7">
                <div class="flex items-center gap-4 text-sm font-semibold text-slate-700">
                    <span class="h-px flex-1 bg-slate-400"></span>
                    <span>Kamu Organizer Event?</span>
                    <span class="h-px flex-1 bg-slate-400"></span>
                </div>

                <a id="partner-link" href="{{ route('organizer_auth.login') }}"
                    class="mt-5 w-full inline-flex items-center justify-center rounded-2xl border-2 border-indigo-100 bg-indigo-50 py-3.5 font-semibold text-indigo-700 hover:border-indigo-200 hover:bg-indigo-100 transition">
                    Login Sebagai Organizer
                </a>
            </div>
        </section>

</main>

<script>
    const activeTab = @json($activeTab ?? 'login');
    const loginTab = document.getElementById('tab-login');
    const registerTab = document.getElementById('tab-register');
    const panelLogin = document.getElementById('panel-login');
    const panelRegister = document.getElementById('panel-register');
    const partnerLink = document.getElementById('partner-link');
    const loginSubmitBtn = document.getElementById('login-submit-btn');
    const registerSubmitBtn = document.getElementById('register-submit-btn');

    function setTab(tab) {
        if (tab === 'register') {
            loginTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-500 bg-transparent';
            registerTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-900 bg-white shadow-sm';
            panelLogin.classList.add('hidden');
            panelRegister.classList.remove('hidden');
            partnerLink.href = '{{ route('organizer_auth.register') }}';
            partnerLink.textContent = 'Daftar Sebagai Organizer';
            loginSubmitBtn?.classList.add('hidden');
            registerSubmitBtn?.classList.remove('hidden');
        } else {
            loginTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-900 bg-white shadow-sm';
            registerTab.className = 'flex-1 rounded-3xl px-5 py-3 font-semibold text-slate-500 bg-transparent';
            panelLogin.classList.remove('hidden');
            panelRegister.classList.add('hidden');
            partnerLink.href = '{{ route('organizer_auth.login') }}';
            partnerLink.textContent = 'Masuk sebagai Organizer';
            loginSubmitBtn?.classList.remove('hidden');
            registerSubmitBtn?.classList.add('hidden');
        }
    }

    loginTab.addEventListener('click', () => setTab('login'));
    registerTab.addEventListener('click', () => setTab('register'));

    setTab(activeTab);
</script>
@endsection
