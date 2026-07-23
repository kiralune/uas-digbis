<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; padding: 24px; color: #0f172a;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e2e8f0;">
        <h1 style="margin-top: 0; color: #4f46e5;">Bagikan Ulasan Acara Anda</h1>
        <p>Terima kasih sudah hadir di <strong>{{ $transaction->event->title }}</strong>.</p>
        <p>Sekarang acara sudah selesai, kami mengundang Anda untuk memberi rating 1-5 bintang dan testimoni singkat agar penyelenggara bisa terus berkembang.</p>
        <p style="margin: 24px 0;">
            <a href="{{ route('reviews.create', $transaction->order_id) }}" style="display: inline-block; background: #4f46e5; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 10px; font-weight: bold;">Beri Rating Sekarang</a>
        </p>
        <p style="font-size: 12px; color: #64748b;">Link ini hanya aktif untuk transaksi yang valid dan dibuka setelah acara selesai.</p>
    </div>
</body>
</html>