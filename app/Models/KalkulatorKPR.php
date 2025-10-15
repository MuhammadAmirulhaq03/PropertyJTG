<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalkulatorKpr extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendapatan_bulanan',
        'harga_properti',
        'dp',
        'tenor',
        'tipe_uang',
        'hasil_simulasi',
        'validasi',
        'customer_id',
    ];

        public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
