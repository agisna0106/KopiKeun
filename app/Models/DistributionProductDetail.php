<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionProductDetail extends Model
{
    protected $fillable = [
        'distribution_id',
        'base_drink_id',
        'quantity_distributed',
        'quantity_returned',
    ];

    protected $casts = [
        'quantity_distributed' => 'decimal:2',
        'quantity_returned' => 'decimal:2',
    ];

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(
            Distribution::class,
            'distribution_id'
        );
    }

    public function baseDrink(): BelongsTo
    {
        return $this->belongsTo(
            BaseDrink::class,
            'base_drink_id'
        );
    }
}