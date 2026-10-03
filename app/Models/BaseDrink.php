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
        'bottle_capacity_ml' => 'integer',
        'standard_serving_ml' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'base_drink_id'
        );
    }

    public function distributionDetails(): HasMany
    {
        return $this->hasMany(
            DistributionProductDetail::class,
            'base_drink_id'
        );
    }
}
