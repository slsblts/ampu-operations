<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'inventory_id',
        'item_name',
        'quantity',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}