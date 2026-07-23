<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'partner_id',
        'transaction_id',
        'customer_name',
        'customer_email',
        'rating',
        'testimonial',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partners::class, 'partner_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}