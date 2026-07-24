<?php

namespace App\Services;

use App\Mail\CertificateMail;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function generateForTransaction(Transaction $transaction): ?string
    {
        if (! $transaction->event || ! $transaction->event->certificate_enabled) {
            return null;
        }

        if ($transaction->certificate_path && Storage::disk('public')->exists($transaction->certificate_path)) {
            return $transaction->certificate_path;
        }

        $fileName = 'certificates/' . Str::slug($transaction->event->title) . '-' . $transaction->order_id . '.pdf';
        $html = view('certificates.template', [
            'transaction' => $transaction,
            'event' => $transaction->event,
            'participantName' => $transaction->customer_name,
        ])->render();

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        Storage::disk('public')->put($fileName, $pdf->output());

        $transaction->update([
            'certificate_path' => $fileName,
        ]);

        return $fileName;
    }

    public function sendCertificate(Transaction $transaction): bool
    {
        $path = $this->generateForTransaction($transaction);

        if (! $path) {
            return false;
        }

        if ($transaction->certificate_sent_at) {
            return true;
        }

        try {
            Mail::to($transaction->customer_email)->send(new CertificateMail($transaction, $path));
            $transaction->update([
                'certificate_sent_at' => now(),
            ]);

            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    public function markAttendance(Transaction $transaction): void
    {
        $wasAttended = $transaction->attendance_status === 'attended';

        if (! $wasAttended) {
            $transaction->update([
                'attendance_status' => 'attended',
                'attendance_verified_at' => now(),
            ]);
        } elseif (! $transaction->attendance_verified_at) {
            $transaction->update([
                'attendance_verified_at' => now(),
            ]);
        }

        $this->sendCertificate($transaction);
    }
}
