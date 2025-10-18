<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentUpload extends Model
{
    use HasFactory;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_REVISION = 'needs_revision';

    public const STATUSES = [
        self::STATUS_SUBMITTED,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
        self::STATUS_REVISION,
    ];

    public static function statusLabels(): array
    {
        return [
            self::STATUS_SUBMITTED => __('Submitted'),
            self::STATUS_APPROVED => __('Approved'),
            self::STATUS_REJECTED => __('Rejected'),
            self::STATUS_REVISION => __('Needs Revision'),
        ];
    }

    protected $fillable = [
        'user_id',
        'document_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'status',
        'review_notes',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function statusLabel(): string
    {
        return static::statusLabels()[$this->status] ?? __('Submitted');
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_APPROVED => 'bg-emerald-100 text-emerald-700',
            self::STATUS_REJECTED => 'bg-red-100 text-red-700',
            self::STATUS_REVISION => 'bg-amber-100 text-amber-700',
            default => 'bg-slate-100 text-slate-600',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
