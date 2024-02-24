<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetResource\Pages;
use App\Filament\Resources\SetResource\RelationManagers;
use App\Models\Set;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SetResource extends Resource
{
    protected static ?string $model = Set::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('info')
                    ->schema([
                        ImageEntry::make('icon')
                            ->hiddenLabel()
                            ->defaultImageUrl(fn($record) => $record->icon_svg_uri)
                            ->alignCenter()
                            ->alignJustify(),
                        TextEntry::make('released_at')
                            ->date(),
                        TextEntry::make('card_count'),
                    ])
                    ->columns(3)
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('released_at')
                    ->sortable(),
                Tables\Columns\TextColumn::make('set_type'),
                TextColumn::make('cards_count')
                    ->sortable()
                    ->counts('cards')
                    ->label('# Cards in Our Collection'),
                Tables\Columns\TextColumn::make('card_count')
                    ->label('# cards in set'),
            ])
            ->filters([
                Tables\Filters\Filter::make('present')
                    ->label('Show sets with cards in our collection')
                    ->toggle()
                    ->default()
                    ->query(fn(Builder $query) => $query->present()),
                Tables\Filters\SelectFilter::make('set_type')
                    ->options([
                        'core' => 'Core',
                        'expansion' => 'Expansion',
                        'masters' => 'Masters',
                        'masterpiece' => 'Masterpiece',
                        'from_the_vault' => 'From the Vault',
                        'spellbook' => 'Spellbook',
                        'premium_deck' => 'Premium Deck',
                        'duel_deck' => 'Duel Deck',
                        'draft_innovation' => 'Draft Innovation',
                        'treasure_chest' => 'Treasure Chest',
                        'commander' => 'Commander',
                        'planechase' => 'Planechase',
                        'archenemy' => 'Archenemy',
                        'vanguard' => 'Vanguard',
                        'funny' => 'Funny',
                        'starter' => 'Starter',
                        'box' => 'Box',
                        'promo' => 'Promo',
                        'token' => 'Token',
                        'memorabilia' => 'Memorabilia',
                    ]),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])

            ->bulkActions([
            ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CardsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSets::route('/'),
            'view' => Pages\ViewSet::route('/{record}/'),
        ];
    }
}
