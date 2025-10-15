<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'customer_id');
    }

    public function crm()
    {
        return $this->hasMany(Crm::class, 'customer_id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'customer_id');
    }

    public function kalkulatorKpr()
    {
        return $this->hasMany(KalkulatorKpr::class, 'customer_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'customer_id');
    }

    public function properti()
    {
        return $this->belongsToMany(Properti::class, 'akses_properti', 'customer_id', 'properti_id');
    }

    public function progressProyek()
    {
        return $this->belongsToMany(ProgressProyek::class, 'baca_progress_proyek', 'customer_id', 'progress_id');
    }

}
