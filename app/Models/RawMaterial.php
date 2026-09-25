<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RawMaterial extends Model
{
    protected $table = 'raw_materials';

    protected $fillable = [
        'name',
        'unit',
        'current_stock',
        'minimum_stock',
        'status',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
    ];

    public function stockRecords(): HasMany
    {
        return $this->hasMany(
            RawMaterialStockRecord::class,
            'raw_material_id'
        );
    }
}
