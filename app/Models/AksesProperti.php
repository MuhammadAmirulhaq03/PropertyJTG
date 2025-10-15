<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesProperti extends Model
{
    use HasFactory;

    protected $table = 'akses_properti';

    protected $fillable = [
        'customer_id',
        'properti_id',
    ];

    public $timestamps = false;

        public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }

}
