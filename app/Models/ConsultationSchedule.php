<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_konsultan',
        'tanggal',
        'waktu',
        'catatan',
    ];

    /**
     * Customer who created this schedule.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
