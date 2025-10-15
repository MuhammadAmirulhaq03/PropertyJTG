<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_waktu',
        'status',
        'agen_id',
        'customer_id',
    ];

        public function agen()
    {
        return $this->belongsTo(Agen::class, 'agen_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function jasaDanLayanan()
    {
        return $this->hasOne(JasaDanLayanan::class, 'jadwal_id');
    }

    public function jadwalKunjungan()
    {
        return $this->hasOne(JadwalKunjungan::class, 'jadwal_id');
    }
}
