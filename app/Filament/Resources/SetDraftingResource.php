<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetDraftingResource\Pages;
use App\Filament\Resources\SetDraftingResource\RelationManagers;
use App\Models\Set;
use App\Models\SetDrafting;
use Awcodes\Shout\Components\Shout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SetDraftingResource extends Resource
{
    protected static ?string $model = Set::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationLabel = 'Drafting';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Shout::make('info')
                    ->content('Update # of draft packs we have for this edition.'),
                Forms\Components\TextInput::make('draft_pack_count')
                    ->label('Draft Pack Count')
                    ->placeholder('Enter the number of draft packs we have for this edition.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('released_at')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('draft_pack_count')
                    ->label('# Draft Packs Available')
                    ->getStateUsing(fn (Set $record) => $record->draft_pack_count . ' packs (' . $record->draft_pack_count / 3 . ' per person)')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('hasDraftPacks')
                    ->label('Show sets with draft packs available')
                    ->toggle()
                    ->default()
                    ->query(fn(Builder $query) => $query->hasDraftPacks()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ])
            ->defaultSort('draft_pack_count', 'desc');
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
            'index' => Pages\ListSetDraftings::route('/'),
        ];
    }
}
