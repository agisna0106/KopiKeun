<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalExpense extends Model
{
    protected $table = 'operational_expenses';

    protected $fillable = [
        'name',
        'amount',
        'expense_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'integer',
        'expense_date' => 'date',
    ];
}
