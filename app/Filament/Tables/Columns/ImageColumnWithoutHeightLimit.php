<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\ImageColumn;

class ImageColumnWithoutHeightLimit extends ImageColumn
{
    protected string $view = 'filament.tables.columns.image-column';

}
