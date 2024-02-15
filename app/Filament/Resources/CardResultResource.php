<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardResultResource\Pages;
use App\Filament\Resources\CardResultResource\RelationManagers;
use App\Models\Card;
use App\Models\CardResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardResultResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return 'Results';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(['name', 'oracle_text', 'type_line']),
                TextColumn::make('card_wants_count')
                    ->label('# Results')
                    ->counts('cardWants')
                    ->sortable(),
                TextColumn::make('card_wants_not_want')
                    ->label('# Not Want'),
                TextColumn::make('card_wants_want')
                    ->label('# Want'),
                TextColumn::make('card_wants_really_want')
                    ->label('# Really Want'),
                TextColumn::make('card_wants_really_really_want')
                    ->label('# Really Really Want'),
                Tables\Columns\ImageColumn::make('image')
                    ->height('auto')
                    ->extraImgAttributes(['class' => 'w-full'])
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('quantity')
                    ->formatStateUsing(fn(int $state) => $state > 1 ? "Count: " . $state : 'Count: 1')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('foil')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Foil' : 'Not Foil')
                    ->badge()
                    ->color(fn(bool $state) => $state ? 'primary' : 'grey')
                    ->alignCenter()
            ])
            ->defaultSort('card_wants_count', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('colours')
                    ->relationship('colours', 'name')
                    ->preload()
                    ->multiple(),
                Tables\Filters\SelectFilter::make('cardTypes')
                    ->relationship('cardTypes', 'name')
                    ->preload()
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('foil')
                    ->placeholder('Any')
                    ->trueLabel('Foil')
                    ->falseLabel('Non-Foil'),
                Tables\Filters\TernaryFilter::make('quantity')
                    ->queries(
                        true: fn(Builder $query) => $query->where('quantity', '>', 1),
                        false: fn(Builder $query) => $query->where('quantity', 1),
                    )
                    ->placeholder('Any')
                    ->trueLabel('More than 1')
                    ->falseLabel('Only 1')

            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCardResults::route('/'),
        ];
    }
}
