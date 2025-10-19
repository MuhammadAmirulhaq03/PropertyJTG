<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertiMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'properti_id',
        'disk',
        'media_path',
        'media_type',
        'caption',
        'sort_order',
        'is_primary',
        'filesize',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
        'filesize' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $media): void {
            if ($media->media_path && Storage::disk($media->disk)->exists($media->media_path)) {
                Storage::disk($media->disk)->delete($media->media_path);
            }
        });
    }

    public function properti()
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }

    public function getUrlAttribute(): string
    {
        if (! $this->media_path) {
            return '';
        }

        $disk = Storage::disk($this->disk);

        if ($disk->exists($this->media_path)) {
            return $disk->url($this->media_path);
        }

        return asset('storage/'.$this->media_path);
    }
}
