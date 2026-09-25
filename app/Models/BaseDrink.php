<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaseDrink extends Model
{
    protected $table = 'base_drinks';

    protected $fillable = [
        'name',
        'bottle_capacity_ml',
        'standard_serving_ml',
        'status',
    ];

    protected $casts = [
        'bottle_capacity_ml' => 'decimal:2',
        'standard_serving_ml' => 'decimal:2',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'base_drink_id'
        );
    }
}
