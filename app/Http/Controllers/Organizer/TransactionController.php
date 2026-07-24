<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\CertificateService;
use Illuminate\Http\RedirectResponse;
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

        $query = Transaction::with('event');

        if ($user?->role === 'organizer') {
            $query->where('organization_id', $user->organization_id);
        }

        $transactions = $query->latest()->paginate(20);
        return view('organizer.transactions.index', compact('transactions'));
    }

    public function markAttendance(Transaction $transaction, CertificateService $service): RedirectResponse
    {
        if (Auth::user()?->role !== 'organizer') {
            abort(403);
        }

        $service->markAttendance($transaction);

        return redirect()->back()->with('success', 'Kehadiran berhasil divalidasi dan e-certificate diproses.');
    }
}