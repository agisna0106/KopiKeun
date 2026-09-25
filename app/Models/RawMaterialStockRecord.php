<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawMaterialStockRecord extends Model
{
    protected $table = 'raw_material_stock_records';

    protected $fillable = [
        'raw_material_id',
        'stock',
        'recorded_at',
        'notes',
    ];

    protected $casts = [
        'stock' => 'decimal:2',
        'recorded_at' => 'date',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(
            RawMaterial::class,
            'raw_material_id'
        );
    }
}
