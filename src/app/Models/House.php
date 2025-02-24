<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    protected $fillable = ['owner_id', 'title', 'description', 'price_per_night', 'location', 'isAvailable', 'contact_phone', 'contact_email'];

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function images() : HasMany
    {
        return $this->hasMany(HouseImage::class);
    }
}
