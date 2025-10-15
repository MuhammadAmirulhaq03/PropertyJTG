<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressProyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'tanggal',
        'media',
        'admin_id',
    ];

        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'baca_progress_proyek', 'progress_id', 'customer_id');
    }
}
