<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(
            Assignment::class,
            'cart_id'
        );
    }
}
