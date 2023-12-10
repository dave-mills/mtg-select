<?php

namespace App\Filament\Resources\CardResource\Pages;

use App\Enums\WantStatus;
use App\Filament\Imports\CardImporter;
use App\Filament\Resources\CardResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListCards extends ListRecords
{
    protected static string $resource = CardResource::class;

    public function getMaxContentWidth(): MaxWidth|string|null
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
                        Actions\ImportAction::make()
            ->importer(CardImporter::class),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'not_reviewed' => Tab::make()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereDoesntHave('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id);
                });
            }),
            'not_want' => Tab::make()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id)
                    ->where('state', WantStatus::NotWant);
                });
            }),
            'want' => Tab::make()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id)
                    ->where('state', WantStatus::Want);
                });
            }),
            'really_want' => Tab::make()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id)
                    ->where('state', WantStatus::ReallyWant);
                });
            }),

            'really_really_want' => Tab::make()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id)
                    ->where('state', WantStatus::ReallyReallyWant);
                });
            }),
        ];


    }
}
