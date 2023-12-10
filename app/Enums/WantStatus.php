<?php

namespace App\Enums;

enum WantStatus: string implements \Filament\Support\Contracts\HasLabel
{

    case None = 'none';
    case Want = 'want';
    case ReallyWant = 'really want';
    case ReallyReallyWant = 'really really want';



    public function getLabel(): ?string
    {
        return match ($this) {
            self::None => 'None',
            self::Want => 'Want',
            self::ReallyWant => 'Really Want',
            self::ReallyReallyWant => 'Really Really Want',
        };
    }
}
