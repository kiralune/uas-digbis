<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user?->role === 'organizer' && ! $user?->organization_id) {
            abort(403, 'Akun organizer belum terhubung ke organisasi.');
        }

        if ($user?->role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        }

        $organizationId = null;

        $eventQuery = Event::query();
        $transactionQuery = Transaction::query();

        if ($organizationId !== null) {
            $eventQuery->where('organization_id', $organizationId);
            $transactionQuery->where('organization_id', $organizationId);
        }

        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->sum('total_price');
        
        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->count();
        
        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = (clone $eventQuery)->where('date', '>=', now())->count();
        
        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = (clone $transactionQuery)->where('status', 'pending')->count();
        
        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = (clone $transactionQuery)->with('event')->latest()->take(5)->get();

        return view('organizer.dashboard', compact('totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions'));
    }
}