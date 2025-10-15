<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'komentar',
        'tanggal',
        'customer_id',
        'admin_id',
        'properti_id',
    ];

        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }
}
