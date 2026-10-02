<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}