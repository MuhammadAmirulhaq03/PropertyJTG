<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentAccessRequest extends Model
{
    protected $fillable = [
        'user_id', 'agent_id', 'status', 'note', 'requested_at', 'decided_at', 'decided_by',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'decided_at' => 'datetime',
    ];

    public const STATUS_REQUESTED = 'requested';
    public const STATUS_APPROVED  = 'approved';
    public const STATUS_REJECTED  = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function decider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}

