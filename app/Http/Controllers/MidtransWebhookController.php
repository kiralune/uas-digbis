<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('=== MIDTRANS CALLBACK MASUK ===');
        Log::info($request->all());

        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $transaction->status = 'challenge';
            } elseif ($fraudStatus === 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus === 'settlement') {
            $transaction->status = 'success';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        return response()->json(['message' => 'OK']);
    }

        private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;
        
        // Jika tiket masih ada dan terhubung dengan data event, kurangi jumlahnya sebanyak 1
        if ($event && $event->stock > 0) {
            $event->stock = $event->stock - 1;
            $event->save();
            
            // Mengirimkan email E-Ticket ke pelanggan
            try {
                Log::info('Sending ticket email from webhook', [
                    'transaction_id' => $transaction->id,
                    'email' => $transaction->customer_email,
                ]);

                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));

                Log::info('Ticket email sent from webhook', [
                    'transaction_id' => $transaction->id,
                    'email' => $transaction->customer_email,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage(), [
                    'transaction_id' => $transaction->id,
                    'email' => $transaction->customer_email,
                ]);
            }
        } else {
            \Log::warning('Stock habis setelah pembayaran berhasil (Perlu proses refund opsional). Order: ' . $transaction->order_id);
        }
    }
}