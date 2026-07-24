<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; color: #111827;">
    <h2 style="color: #4338ca;">E-Certificate Anda Sudah Siap</h2>
    <p>Halo {{ $transaction->customer_name }},</p>
    <p>Sertifikat kehadiran Anda untuk acara <strong>{{ $transaction->event->title }}</strong> telah dibuat dan dilampirkan dalam email ini.</p>
    <p>Terima kasih atas partisipasi Anda.</p>
</body>
</html>
