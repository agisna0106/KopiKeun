<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemainingProductDetail extends Model
{
    use HasFactory;

    protected $table = 'remaining_product_details';

    protected $fillable = [
        'remaining_product_id',
        'base_drink_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    public function remainingProduct(): BelongsTo
    {
        return $this->belongsTo(
            RemainingProduct::class,
            'remaining_product_id'
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
