<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private function authorizeReviewWindow(Transaction $transaction): void
    {
        $transaction->loadMissing('event.partner', 'review');

        abort_unless($transaction->status === 'success', 403, 'Hanya transaksi sukses yang dapat direview.');
        abort_if(now()->lt($transaction->event->date->copy()->addDay()), 403, 'Review baru dibuka satu hari setelah acara selesai.');
    }

    public function create(Transaction $transaction)
    {
        $this->authorizeReviewWindow($transaction);

        abort_if((bool) $transaction->review, 409, 'Review untuk transaksi ini sudah ada. Gunakan halaman edit.');

        return view('reviews.create', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeReviewWindow($transaction);

        abort_unless((bool) $transaction->review, 404, 'Review belum tersedia untuk diedit.');

        return view('reviews.create', [
            'transaction' => $transaction,
            'review' => $transaction->review,
        ]);
    }

    public function store(Request $request, Transaction $transaction)
    {
        $this->authorizeReviewWindow($transaction);

        if ($transaction->review) {
            if ($transaction->event->organization) {
                return redirect()->route('organizers.show', $transaction->event->organization)->with('info', 'Review untuk transaksi ini sudah dikirim.');
            }

            return redirect()->route('events.show', $transaction->event)->with('info', 'Review untuk transaksi ini sudah dikirim.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'event_id' => $transaction->event_id,
            'partner_id' => $transaction->event->partner_id,
            'transaction_id' => $transaction->id,
            'customer_name' => $transaction->customer_name,
            'customer_email' => $transaction->customer_email,
            'rating' => $data['rating'],
            'testimonial' => $data['testimonial'] ?? null,
            'submitted_at' => now(),
        ]);

        return redirect()->route('ticket')->with('success', 'Terima kasih, ulasan Anda sudah disimpan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeReviewWindow($transaction);

        abort_unless((bool) $transaction->review, 404, 'Review belum tersedia untuk diedit.');

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'nullable|string|max:1000',
        ]);

        $transaction->review->update([
            'rating' => $data['rating'],
            'testimonial' => $data['testimonial'] ?? null,
            'submitted_at' => now(),
        ]);

        return redirect()->route('ticket')->with('success', 'Review berhasil diperbarui.');
    }
}