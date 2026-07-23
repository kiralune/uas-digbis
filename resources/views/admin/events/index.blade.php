@extends('layouts.admin')

@section('page_title', 'Manajemen Event')
@section('page_subtitle', 'Pantau semua event platform beserta statusnya dari satu panel.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-black text-slate-900">Semua Event Platform</h2>
        <p class="text-sm text-slate-500">Status event dapat dilihat langsung pada daftar berikut.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-slate-500">
                    <th class="py-3 pr-4">Event</th>
                    <th class="py-3 pr-4">Organisasi</th>
                    <th class="py-3 pr-4">Kategori</th>
                    <th class="py-3 pr-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 pr-4">
                            <p class="font-semibold text-slate-900">{{ $event->title }}</p>
                            <p class="text-xs text-slate-500">{{ $event->date?->format('d M Y') }}</p>
                        </td>
                        <td class="py-3 pr-4">{{ $event->organization?->name ?? '-' }}</td>
                        <td class="py-3 pr-4">{{ $event->category?->name ?? '-' }}</td>
                        <td class="py-3 pr-4">
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $event->date >= now() ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">{{ $event->date >= now() ? 'Aktif' : 'Selesai' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-slate-500">Belum ada event.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection
