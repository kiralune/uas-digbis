<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user?->role !== 'organizer' || ! $user?->organization_id) {
            abort(403, 'Akses hanya untuk organizer yang terdaftar.');
        }

        $organizationId = $user->organization_id;

        $eventQuery = Event::where('organization_id', $organizationId);
        $transactionQuery = Transaction::where('organization_id', $organizationId);

        $totalRevenue = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->sum('total_price');
        $ticketsSold = (clone $transactionQuery)->whereIn('status', ['settlement', 'success'])->count();
        $activeEvents = (clone $eventQuery)->where('date', '>=', now())->count();
        $pendingOrders = (clone $transactionQuery)->where('status', 'pending')->count();
        $recentTransactions = (clone $transactionQuery)->with('event')->latest()->take(5)->get();

        return view('admin.organizer.dashboard', compact('totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions'));
    }
}
