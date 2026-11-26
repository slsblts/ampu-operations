<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    protected $table = 'detail_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'inventori_id',
        'nama_barang',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Loan::class, 'peminjaman_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventori_id');
    }
}