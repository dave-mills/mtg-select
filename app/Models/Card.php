<?php

namespace App\Models;

use App\Enums\WantStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{

    protected $casts = [
        'scryfall_data' => 'array',
        'foil' => 'boolean',
    ];

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'code', 'set_code');
    }

    public function colours(): BelongsToMany
    {
        return $this->belongsToMany(Colour::class);
    }

    public function cardTypes(): BelongsToMany
    {
        return $this->belongsToMany(CardType::class);
    }


    public function users(): BelongsToMany
    {
        return  $this->belongsToMany(User::class)
            ->withPivot('state');
    }

    public function cardWants(): HasMany
    {
        return $this->hasMany(CardWant::class);
    }

    public function getStatusFor(User $user): ?WantStatus
    {
        return WantStatus::from($this->cardWants()
            ->where('user_id', $user->id)
            ->first()
            ?->state ?? 'none');
    }

}
