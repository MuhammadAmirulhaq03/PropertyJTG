<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentUpload extends Model
{
    use HasFactory;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
