<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'status',
        'customer_id',
        'admin_id',
    ];

        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
