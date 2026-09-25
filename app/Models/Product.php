<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'base_drink_id',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function baseDrink(): BelongsTo
    {
        return $this->belongsTo(
            BaseDrink::class,
            'base_drink_id'
        );
    }
}
