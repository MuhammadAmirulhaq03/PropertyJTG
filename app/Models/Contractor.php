<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'phone',
        'alamat',
        'luas_bangunan_lahan',
        'titik_lokasi',
        'pesan',
    ];
}
