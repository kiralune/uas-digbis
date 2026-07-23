<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'event_id', 'order_id', 'customer_name', 'customer_email', 'customer_phone', 'total_price', 'status', 'snap_token', 'review_reminder_sent_at'
    ];

    protected $casts = [
        'review_reminder_sent_at' => 'datetime',
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