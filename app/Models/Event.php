<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'organization_id', 'category_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path'
        ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function getPosterUrlAttribute(): string
    {
        if (! $this->poster_path) {
            return 'https://placehold.co/400x600';
        }

        if (Str::startsWith($this->poster_path, ['http://', 'https://'])) {
            return $this->poster_path;
        }

        $relativePath = ltrim($this->poster_path, '/');

        if (Str::startsWith($relativePath, 'storage/')) {
            return asset($relativePath);
        }

        if (Storage::disk('public')->exists($relativePath)) {
            return asset('storage/' . $relativePath);
        }

        return 'https://placehold.co/400x600';
    }
}
