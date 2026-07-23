@extends('layouts.admin')

@section('page_title', 'Detail Organisasi')
@section('page_subtitle', 'Lihat informasi organisasi, pengguna terkait, dan event yang mereka kelola.')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-600">Organisasi</p>
                <h2 class="text-2xl font-black text-slate-900">{{ $organization->name }}</h2>
                <p class="text-sm text-slate-500">Status saat ini: <span class="font-semibold text-slate-700">{{ ucfirst($organization->status) }}</span></p>
            </div>
            <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                <p class="font-semibold">Jumlah Event</p>
                <p class="text-2xl font-black text-slate-900">{{ $events->count() }}</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-black text-slate-900">Pengguna Terkait</h3>
            <ul class="mt-4 space-y-3">
                @forelse($organization->users as $user)
                    <li class="rounded-2xl border border-slate-200 p-3">
                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $user->email }} • {{ ucfirst($user->role) }}</p>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Belum ada pengguna yang terhubung.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-black text-slate-900">Event yang Dikelola</h3>
            <ul class="mt-4 space-y-3">
                @forelse($events as $event)
                    <li class="rounded-2xl border border-slate-200 p-3">
                        <p class="font-semibold text-slate-900">{{ $event->title }}</p>
                        <p class="text-sm text-slate-500">{{ $event->category?->name ?? '-' }} • {{ $event->date?->format('d M Y') }}</p>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Belum ada event untuk organisasi ini.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
