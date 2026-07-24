<?php

namespace App\Models;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'partner_id', 'organization_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path', 'certificate_enabled', 'certificate_template'
        ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $appends = ['poster_url'];

    public function getPosterUrlAttribute(): string
    {
        if (! $this->poster_path) {
            return 'https://placehold.co/120x160?text=No+Image';
        }

        if (str_starts_with($this->poster_path, 'http')) {
            return $this->poster_path;
        }

        return asset('storage/' . ltrim($this->poster_path, '/'));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partners::class, 'partner_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
        

    protected static function booted(): void
    {
        static::creating(function ($model) {
            try {
                if (empty($model->organization_id) && auth()->check()) {
                    $orgId = auth()->user()->organization_id ?? null;
                    if ($orgId) {
                        $model->organization_id = $orgId;
                    }
                }
            } catch (\Throwable $e) {
                // don't break creation if auth not available in some contexts
            }
        });
    }

}
