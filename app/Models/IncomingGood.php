<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingGood extends Model
{
    protected $table = 'incoming_goods';

    protected $fillable = [
        'raw_material_id',
        'quantity',
        'unit_cost',
        'received_at',
        'supplier',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'received_at' => 'date',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(
            RawMaterial::class,
            'raw_material_id'
        );
    }
}
