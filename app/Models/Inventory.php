<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_alat',
        'kategori',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'catatan',
    ];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }
}