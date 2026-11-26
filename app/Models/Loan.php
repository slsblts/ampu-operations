<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'nim_nik',
        'no_hp',
        'organisasi',
        'keperluan',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'kondisi_kembali',
        'catatan_kembali',
        'admin_pinjam_id',
        'admin_kembali_id',
    ];

    public function items()
    {
        return $this->hasMany(LoanItem::class, 'peminjaman_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'admin_pinjam_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'admin_kembali_id');
    }
}