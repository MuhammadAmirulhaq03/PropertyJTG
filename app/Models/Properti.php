<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Properti extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'harga',
        'units_available',
        'tipe',
        'status',
        'spesifikasi',
        'deskripsi',
        'tipe_properti',
        'admin_id',
    ];

    protected $casts = [
        'harga' => 'float',
        'units_available' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $property): void {
            $property->media()->get()->each->delete();
        });
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'properti_id');
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'akses_properti', 'properti_id', 'customer_id');
    }

    public function media()
    {
        return $this->hasMany(PropertiMedia::class, 'properti_id')->orderBy('sort_order');
    }

    public function primaryMedia()
    {
        return $this->hasOne(PropertiMedia::class, 'properti_id')->where('is_primary', true);
    }

    public function getPrimaryMediaUrlAttribute(): ?string
    {
        if ($this->relationLoaded('primaryMedia') && $this->primaryMedia) {
            return $this->primaryMedia->url;
        }

        if ($this->relationLoaded('media')) {
            return optional($this->media->sortBy('sort_order')->first())->url;
        }

        $media = $this->media()->orderBy('is_primary', 'desc')->orderBy('sort_order')->first();

        return $media?->url;
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_favorites', 'properti_id', 'user_id')
            ->withTimestamps();
    }
}
