<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = [
        'employee_id',
        'cart_id',
        'region_id',
        'assignment_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'assignment_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}