<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    protected $table = 'sale_details';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Sale detail belongs to a sale.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(
            Sale::class,
            'sale_id'
        );
    }

    /**
     * Sale detail belongs to a product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
}
