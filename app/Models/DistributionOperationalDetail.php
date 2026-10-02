<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionOperationalDetail extends Model
{
    protected $fillable = [
        'distribution_id',
        'operational_item_id',
        'quantity_distributed',
        'quantity_returned',
    ];

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(Distribution::class);
    }

    public function operationalItem(): BelongsTo
    {
        return $this->belongsTo(OperationalItem::class);
    }
}