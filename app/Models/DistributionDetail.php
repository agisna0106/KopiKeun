<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionDetail extends Model
{
    use HasFactory;

    protected $table = 'distribution_details';

    protected $fillable = [
        'distribution_id',
        'base_drink_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
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
