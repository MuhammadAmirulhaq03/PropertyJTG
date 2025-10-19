<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'admin_id',
        'start_at',
        'end_at',
        'location',
        'notes',
        'status',
        'customer_id',
        'booked_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'booked_at' => 'datetime',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->whereNull('customer_id');
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked' && $this->customer_id !== null;
    }

    public function durationMinutes(): int
    {
        if (! $this->start_at || ! $this->end_at) {
            return 0;
        }

        return $this->end_at->diffInMinutes($this->start_at);
    }

    public function overlapsWith(Carbon $start, Carbon $end): bool
    {
        return $this->start_at < $end && $this->end_at > $start;
    }
}
