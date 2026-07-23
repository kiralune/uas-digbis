<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    protected $fillable = ['name', 'logo_url'];

    public function events()
    {
        return $this->hasMany(Event::class, 'partner_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'partner_id');
    }
}
