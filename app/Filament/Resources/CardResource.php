<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardResource\Pages;
use App\Filament\Resources\CardResource\RelationManagers;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\ImageColor;
use App\Enums\WantStatus;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    Tables\Columns\ImageColumn::make('image')
                        ->height('auto')
                        ->extraImgAttributes(['class' => 'w-full'])
                        ->alignCenter(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\Action::make('want')
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::Want)
                    ->color('success')
                ->action(fn(Card $record) => Auth::user()?->want($record)),
                Tables\Actions\Action::make('reallyWant')
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::ReallyWant)
                    ->color('warning')
                ->action(fn(Card $record) => Auth::user()->reallyWant($record)),
                Tables\Actions\Action::make('reallyReallyWant')
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::ReallyReallyWant)
                    ->color('danger')
                ->action(fn(Card $record) => Auth::user()->reallyReallyWant($record)),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                '2xl' => 4,
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
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}
