<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribution extends Model
{
    protected $fillable = [
        'employee_id',
        'distribution_date',
        'notes',
    ];

    protected $casts = [
        'distribution_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(DistributionProductDetail::class);
    }

    public function operationalDetails(): HasMany
    {
        return $this->hasMany(DistributionOperationalDetail::class);
    }
}