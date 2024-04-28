<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Set extends Model
{

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public function scopePresent(Builder $query): void
    {
        $query->whereHas('cards');
    }

    public function scopeHasDraftPacks(Builder $query): void
    {
        $query->where('draft_pack_count', '>', 0);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'set_code', 'code');
    }

}
