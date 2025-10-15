<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'lokasi_kunjungan',
        'cek_ketersediaan',
        'admin_id',
    ];

        public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
