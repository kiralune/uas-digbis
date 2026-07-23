<?php

namespace App\Http\Controllers\Organizer;

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

        $successStatuses = ['settlement', 'success'];
        $paidTransactionsQuery = (clone $transactionQuery)->whereIn('status', $successStatuses);

        $totalRevenue = (clone $paidTransactionsQuery)->sum('total_price');
        $ticketsSold = (clone $paidTransactionsQuery)->count();
        $activeEvents = (clone $eventQuery)->where('date', '>=', now())->count();
        $pendingOrders = (clone $transactionQuery)->where('status', 'pending')->count();
        $recentTransactions = (clone $transactionQuery)->with('event')->latest()->take(5)->get();

        $monthlyRevenue = [];
        $maxMonthlyRevenue = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthRevenue = (clone $paidTransactionsQuery)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_price');

            $monthlyRevenue[] = [
                'label' => $date->translatedFormat('M Y'),
                'value' => (int) $monthRevenue,
            ];

            $maxMonthlyRevenue = max($maxMonthlyRevenue, (int) $monthRevenue);
        }

        $totalSuccessfulTransactions = (clone $paidTransactionsQuery)->count();
        $totalTransactions = (clone $transactionQuery)->count();
        $successRate = $totalTransactions > 0 ? round(($totalSuccessfulTransactions / $totalTransactions) * 100, 1) : 0;
        $averageMonthlyRevenue = $monthlyRevenue !== [] ? (int) round(array_sum(array_column($monthlyRevenue, 'value')) / count($monthlyRevenue)) : 0;

        return view('organizer.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'monthlyRevenue',
            'maxMonthlyRevenue',
            'successRate',
            'averageMonthlyRevenue',
            'totalSuccessfulTransactions',
            'totalTransactions'
        ));
    }
}
