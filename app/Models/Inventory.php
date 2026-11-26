<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventori';

    protected $fillable = [
        'nama_alat',
        'kategori',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'catatan',
    ];

    public function detailPeminjaman()
    {
        return $this->hasMany(LoanItem::class, 'inventori_id');
    }

    public function sedangDipinjam(): bool
    {
        return $this->stok_tersedia < $this->stok_total
            || $this->detailPeminjaman()
                ->whereHas('peminjaman', fn($q) => $q->where('status', 'dipinjam'))
                ->exists();
    }
}