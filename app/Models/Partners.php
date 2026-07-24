<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Partners extends Model
{
    protected $fillable = ['name', 'logo_url'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'partner_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'partner_id');
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Event::class, 'partner_id', 'event_id', 'id', 'id');
    }

    public function getLogoUrlAttribute($value): string
    {
        if (blank($value)) {
            return '';
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        if (Str::startsWith($value, 'storage/')) {
            return asset($value);
        }

        return asset('storage/' . ltrim($value, '/'));
    }
}
