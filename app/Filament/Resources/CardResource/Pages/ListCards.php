<?php

namespace App\Filament\Resources\CardResource\Pages;

use App\Filament\Imports\CardImporter;
use App\Filament\Resources\CardResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

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
}
