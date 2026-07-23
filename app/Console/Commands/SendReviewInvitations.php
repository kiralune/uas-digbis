<?php

namespace App\Console\Commands;

use App\Mail\ReviewInvitationMail;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReviewInvitations extends Command
{
    protected $signature = 'reviews:send-invitations';

    protected $description = 'Send review invitation emails for completed events one day after event date';

    public function handle(): int
    {
        $transactions = Transaction::with('event.partner', 'review')
            ->where('status', 'success')
            ->whereNull('review_reminder_sent_at')
            ->whereHas('event', function ($query) {
                $query->whereDate('date', now()->subDay()->toDateString());
            })
            ->get();

        foreach ($transactions as $transaction) {
            if (!$transaction->review) {
                Mail::to($transaction->customer_email)->send(new ReviewInvitationMail($transaction));
            }

            $transaction->update(['review_reminder_sent_at' => now()]);
        }

        $this->info('Review invitations processed: ' . $transactions->count());

        return self::SUCCESS;
    }
}