<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properti extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'harga',
        'tipe',
        'status',
        'spesifikasi',
        'tipe_properti',
        'admin_id',
    ];

        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'properti_id');
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'akses_properti', 'properti_id', 'customer_id');
    }

}
