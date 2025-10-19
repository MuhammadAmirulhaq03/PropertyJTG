<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function crm()
    {
        return $this->hasMany(Crm::class, 'agen_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'agen_id');
    }

}
