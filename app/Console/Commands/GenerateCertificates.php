<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\CertificateService;
use Illuminate\Console\Command;

class GenerateCertificates extends Command
{
    protected $signature = 'certificates:generate';
    protected $description = 'Generate and send e-certificates for attended transactions';

    public function handle(CertificateService $service): int
    {
        $transactions = Transaction::with('event')
            ->whereHas('event', function ($query) {
                $query->where('certificate_enabled', true);
            })
            ->where('status', 'success')
            ->where('attendance_status', 'attended')
            ->get();

        foreach ($transactions as $transaction) {
            $service->sendCertificate($transaction);
        }

        $this->info('Certificate generation completed.');
        return self::SUCCESS;
    }
}
