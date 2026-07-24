<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Services\CertificateService;
use Mockery;
use Tests\TestCase;

class CertificateServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_mark_attendance_sends_certificate_even_if_transaction_was_already_marked_attended(): void
    {
        $transaction = Mockery::mock(Transaction::class)->makePartial();
        $transaction->attendance_status = 'attended';
        $transaction->attendance_verified_at = null;

        $transaction->shouldReceive('update')->never();

        $service = Mockery::mock(CertificateService::class)->makePartial();
        $service->shouldReceive('sendCertificate')
            ->once()
            ->with($transaction);

        $service->markAttendance($transaction);
    }
}
