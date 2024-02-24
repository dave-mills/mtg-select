<?php

namespace App\Filament\Resources;

use App\Enums\WantStatus;
use App\Filament\Resources\CardCloneResource\Pages;
use App\Filament\Tables\Columns\ImageColumnWithoutHeightLimit;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CardCloneResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Cards - 1by1 review';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('scryfall_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('scryfall_data')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('oracle_text')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('type_line')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('set_name')
                    ->maxLength(255),
                Forms\Components\Textarea::make('image')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ImageColumnWithoutHeightLimit::make('image')
                        ->extraImgAttributes(['class' => 'w-full'])
                        ->alignCenter()
                        ->searchable(['name', 'oracle_text', 'type_line']),
                    TextColumn::make('quantity')
                        ->formatStateUsing(fn(int $state) => $state > 1 ? "Count: " . $state : 'Count: 1')
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('foil')
                        ->formatStateUsing(fn(bool $state) => $state ? 'Foil' : 'Not Foil')
                        ->badge()
                        ->color(fn(bool $state) => $state ? 'primary' : 'grey')
                        ->alignCenter(),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('set')
                    ->relationship('set', 'name', fn(Builder $query) => $query->present())
                    ->preload(),
                Tables\Filters\SelectFilter::make('colours')
                    ->relationship('colours', 'name')
                    ->multiple(),
                Tables\Filters\SelectFilter::make('cardTypes')
                    ->relationship('cardTypes', 'name')
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('foil'),
            ])
            ->actions([

                Tables\Actions\Action::make('notWant')
                    ->label(fn() => WantStatus::NotWant->value)
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::NotWant)
                    ->color('success')
                    ->action(fn(Card $record) => Auth::user()?->notWant($record)),

                Tables\Actions\Action::make('want')
                    ->label(fn() => WantStatus::Want->value)
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::Want)
                    ->color('success')
                    ->action(fn(Card $record) => Auth::user()?->want($record)),
                Tables\Actions\Action::make('reallyWant')
                    ->label(fn() => WantStatus::ReallyWant->value)
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::ReallyWant)
                    ->color('warning')
                    ->action(fn(Card $record) => Auth::user()?->reallyWant($record)),
                Tables\Actions\Action::make('reallyReallyWant')
                    ->label(fn() => WantStatus::ReallyReallyWant->value)
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::ReallyReallyWant)
                    ->color('danger')
                    ->action(fn(Card $record) => Auth::user()?->reallyReallyWant($record)),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereDoesntHave('cardWants', function (Builder $query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->contentGrid([
                'md' => 1,
            ])
            ->paginated([1]);
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
            'index' => Pages\ListCloneCards::route('/'),
        ];
    }
}
