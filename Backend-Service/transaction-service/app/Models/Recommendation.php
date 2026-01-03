<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Recommendation extends Model
{
    use HasUuids;

    protected $fillable = [
        'id_member',
        'id_book',
        'type',
        'score',
        'reason',
        'is_active',
        'recommended_at'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'is_active' => 'boolean',
        'recommended_at' => 'datetime'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForMember($query, $memberId)
    {
        return $query->where('id_member', $memberId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeHighScore($query)
    {
        return $query->orderBy('score', 'desc');
    }
}
