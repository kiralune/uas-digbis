@extends('layouts.admin')

@section('page_title', 'Manajemen Organizer')
@section('page_subtitle', 'Lihat daftar organizer, verifikasi status, dan akses detail organisasi.')

@section('content')
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-slate-900">Daftar Organizer</h2>
            <p class="text-sm text-slate-500">Kelola status verifikasi organizer dan lihat detail organisasi.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-slate-500">
                    <th class="py-3 pr-4">Nama Organisasi</th>
                    <th class="py-3 pr-4">Status</th>
                    <th class="py-3 pr-4">Jumlah Event</th>
                    <th class="py-3 pr-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organizations as $organization)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 pr-4 font-semibold text-slate-900">{{ $organization->name }}</td>
                        <td class="py-3 pr-4">
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $organization->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($organization->status) }}</span>
                        </td>
                        <td class="py-3 pr-4">{{ $organization->events_count }}</td>
                        <td class="py-3 pr-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.organizers.show', $organization->id) }}" class="rounded-xl bg-slate-100 px-3 py-2 font-semibold text-slate-700 hover:bg-slate-200">Detail</a>
                            <form action="{{ route('admin.organizers.verify', $organization->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 font-semibold text-white hover:bg-emerald-700">Verifikasi</button>
                            </form>
                            <form action="{{ route('admin.organizers.verify', $organization->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="rounded-xl bg-amber-500 px-3 py-2 font-semibold text-white hover:bg-amber-600">Tunda</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-slate-500">Belum ada organizer yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
