<?php

namespace App\Filament\Widgets;

use App\Enums\WantStatus;
use App\Models\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class CountAllCards extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('All Cards', Card::count()),
            Stat::make('Reviewed Cards', Auth::user()?->cards()->count()),
            Stat::make('Cards I want', Auth::user()?->cards()->wherePivotIn('state', [
                WantStatus::Want->value,
                WantStatus::ReallyWant->value,
                WantStatus::ReallyReallyWant->value,
            ])->count())


        ];
    }
}
