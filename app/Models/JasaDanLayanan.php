<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaDanLayanan extends Model
{
    use HasFactory;

    protected $table = 'jasa_dan_layanans';

    protected $fillable = [
        'jadwal_id',
        'nama_layanan',
        'kategori',
        'biaya',
    ];

        public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
