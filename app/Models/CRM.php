<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    protected $fillable = [
        'aktivitas_user',
        'riwayat_komunikasi',
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
}
