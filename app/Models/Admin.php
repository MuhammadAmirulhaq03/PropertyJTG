<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function properti()
    {
        return $this->hasMany(Properti::class, 'admin_id');
    }

    public function progressProyek()
    {
        return $this->hasMany(ProgressProyek::class, 'admin_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'admin_id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'admin_id');
    }

    public function jadwalKunjungan()
    {
        return $this->hasMany(JadwalKunjungan::class, 'admin_id');
    }
}
