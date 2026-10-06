<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'sale_source',
        'distribution_id',
        'employee_id',
        'sale_date',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(
            Distribution::class,
            'distribution_id'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            SaleDetail::class,
            'sale_id'
        );
    }
}
