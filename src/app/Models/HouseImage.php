<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Contracts\Role;

class HouseImage extends Model
{
    protected $fillable = ['house_id', 'image_path'];

    public function house() : BelongsTo
    {
        return $this->belongsTo(House::class);
    }

}
