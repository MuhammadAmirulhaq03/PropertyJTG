<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal'; // karena nama tabel tunggal
    protected $fillable = ['nama_konsultan', 'tanggal', 'waktu', 'catatan'];
}
