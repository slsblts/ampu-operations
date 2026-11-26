<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudioBooking extends Model
{
    protected $table = 'jadwal_studio';

    protected $fillable = [
        'nama_studio',
        'nama_acara',
        'pic_kru',
        'tanggal_booking',
        'sesi_jam',
        'status',
        'admin_pembuat_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'admin_pembuat_id');
    }
}