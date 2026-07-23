<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Transaction::class, 'transaction');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user?->role === 'organizer' && ! $user?->organization_id) {
            abort(403, 'Akun organizer belum terhubung ke organisasi.');
        }

        // Mengambil transaksi terbaru dengan pembatasan 20 baris/halaman
        $query = Transaction::with('event');

        if ($user?->role === 'organizer') {
            $query->where('organization_id', $user->organization_id);
        }

        $transactions = $query->latest()->paginate(20);
        return view('organizer.transactions.index', compact('transactions'));
    }
}