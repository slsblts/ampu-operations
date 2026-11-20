<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by_admin_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_admin_id');
    }
}