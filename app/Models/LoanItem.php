<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    protected $guarded = ['id'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}