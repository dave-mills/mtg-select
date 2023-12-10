<?php

namespace App\Filament\Resources\CardCloneResource\Pages;

use App\Enums\WantStatus;
use App\Filament\Imports\CardImporter;
use App\Filament\Resources\CardCloneResource;
use App\Filament\Resources\CardResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListCloneCards extends ListRecords
{
    protected static string $resource = CardCloneResource::class;


    public function getMaxContentWidth(): MaxWidth|string|null
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
