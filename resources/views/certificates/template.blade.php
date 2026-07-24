<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Certificate</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 0; }
        .card { border: 8px solid #4338ca; padding: 32px; margin: 24px; background: white; text-align: center; }
        .title { font-size: 34px; font-weight: bold; color: #312e81; margin-bottom: 12px; }
        .subtitle { font-size: 18px; color: #64748b; margin-bottom: 24px; }
        .name { font-size: 32px; font-weight: bold; color: #111827; margin: 20px 0; }
        .info { font-size: 16px; color: #374151; margin: 8px 0; }
        .badge { display: inline-block; margin-top: 20px; padding: 10px 16px; background: #eef2ff; color: #4338ca; font-weight: bold; border-radius: 999px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">SERTIFIKAT KEHADIRAN</div>
        <div class="subtitle">Diberikan kepada</div>
        <div class="name">{{ $participantName }}</div>
        <div class="info">atas kehadiran sebagai peserta pada acara</div>
        <div class="info"><strong>{{ $event->title }}</strong></div>
        <div class="info">yang diselenggarakan pada {{ $event->date->format('d F Y') }}</div>
        <div class="badge">E-Certificate Otomatis</div>
    </div>
</body>
</html>
