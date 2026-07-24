<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        
        // Get all transactions for the logged-in user by email
        $transactions = Transaction::where('customer_email', $user->email)
            ->with(['event', 'review'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get certificates (transactions with certificate_path)
        $certificates = Transaction::where('customer_email', $user->email)
            ->where('certificate_path', '!=', null)
            ->with('event')
            ->orderBy('certificate_sent_at', 'desc')
            ->get();

        $reviewedCount = $transactions->filter(fn ($transaction) => (bool) $transaction->review)->count();
        $averageRating = $transactions->pluck('review.rating')->filter()->avg();
        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        $pendingReviewTransactions = $transactions->filter(function ($transaction) {
            if ($transaction->review || $transaction->status !== 'success' || ! $transaction->event?->date) {
                return false;
            }

            return \Carbon\Carbon::parse($transaction->event->date)->copy()->addDay()->lte(now());
        });

        $pendingReviewCount = $pendingReviewTransactions->count();
        $reviewTransactions = $transactions->filter(fn ($transaction) => $transaction->review);
        
        return view('profile', compact(
            'transactions',
            'certificates',
            'reviewedCount',
            'pendingReviewCount',
            'averageRating',
            'pendingReviewTransactions',
            'reviewTransactions'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
