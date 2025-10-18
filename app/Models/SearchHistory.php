<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'filters',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'filters' => 'array',
    ];

    /**
     * The user that owns the search history entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve the raw filters that were applied.
     *
     * @return array<string, mixed>
     */
    public function rawFilters(): array
    {
        return (array) data_get($this->filters, 'raw', []);
    }

    /**
     * Retrieve the human friendly filters summary.
     *
     * @return array<string, mixed>
     */
    public function activeFilters(): array
    {
        return (array) data_get($this->filters, 'active', []);
    }
}

