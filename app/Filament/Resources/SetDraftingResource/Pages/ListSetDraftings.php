<?php

namespace App\Filament\Resources\SetDraftingResource\Pages;

use App\Filament\Resources\SetDraftingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSetDraftings extends ListRecords
{
    protected static string $resource = SetDraftingResource::class;

    protected ?string $heading = 'Drafting Sets';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
