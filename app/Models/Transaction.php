<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'event_id', 'order_id', 'customer_name', 'customer_email', 'customer_phone', 'total_price', 'status', 'snap_token', 'review_reminder_sent_at', 'attendance_status', 'attendance_verified_at', 'certificate_path', 'certificate_sent_at', 'organization_id'
    ];

    protected $casts = [
        'review_reminder_sent_at' => 'datetime',
        'attendance_verified_at' => 'datetime',
        'certificate_sent_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}