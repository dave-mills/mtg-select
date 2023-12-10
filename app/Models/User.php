<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\WantStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)
            ->withPivot('state');
    }

    public function cardWants(): HasMany
    {
        return $this->hasMany(CardWant::class);
    }

    public function notWant(Card $card)
    {
        if ($this->whereHas('cardWants', function ($q) use ($card) {
            $q->where('card_id', $card->id)
                ->where('state', WantStatus::NotWant)
                ->where('user_id', $this->id);
        })->exists()) {
            $this->cards()->detach($card);
        } else {
            $this->cards()->syncWithoutDetaching([
                $card->id => ['state' => WantStatus::NotWant],
            ]);

            // send notification
            Notification::make('Choice Saved')
                ->body('You have marked ' . $card->name . ' with the status: ' . WantStatus::NotWant->value)
                ->duration(10000)
                ->success()
                ->send();
        }
    }

    public function want(Card $card)
    {
        if ($this->whereHas('cardWants', function ($q) use ($card) {
            $q->where('card_id', $card->id)
                ->where('state', WantStatus::Want)
                ->where('user_id', $this->id);
        })->exists()) {
            $this->cards()->detach($card);
        } else {
            $this->cards()->syncWithoutDetaching([
                $card->id => ['state' => WantStatus::Want],
            ]);

            // send notification
            Notification::make('Choice Saved')
                ->body('You have marked ' . $card->name . ' with the status: ' . WantStatus::Want->value)
                ->duration(10000)
                ->success()
                ->send();
        }
    }

    public function reallyWant(Card $card)
    {
        if ($this->whereHas('cardWants', function ($q) use ($card) {
            $q->where('card_id', $card->id)
                ->where('state', WantStatus::ReallyWant)
                ->where('user_id', $this->id);
        })->exists()) {
            $this->cards()->detach($card);
        } else {
            $this->cards()->syncWithoutDetaching([
                $card->id => ['state' => WantStatus::ReallyWant],
            ]);

            // send notification
            Notification::make('Choice Saved')
                ->body('You have marked ' . $card->name . ' with the status: ' . WantStatus::ReallyWant->value)
                ->duration(10000)
                ->success()
                ->send();
        }
    }

    public function reallyReallyWant(Card $card)
    {
        if ($this->whereHas('cardWants', function ($q) use ($card) {
            $q->where('card_id', $card->id)
                ->where('state', WantStatus::ReallyReallyWant)
                ->where('user_id', $this->id);
        })->exists()) {
            $this->cards()->detach($card);
        } else {
            $this->cards()->syncWithoutDetaching([
                $card->id => ['state' => WantStatus::ReallyReallyWant],
            ]);

            // send notification
            Notification::make('Choice Saved')
                ->body('You have marked ' . $card->name . ' with the status: ' . WantStatus::ReallyReallyWant->value)
                ->duration(10000)
                ->success()
                ->send();
        }
    }
}
