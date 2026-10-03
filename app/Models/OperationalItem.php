<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperationalItem extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'minimum_stock',
        'status',
    ];

    public function distributionDetails(): HasMany
    {
        return $this->hasMany(
            DistributionOperationalDetail::class,
            'operational_item_id'
        );
    }
}
