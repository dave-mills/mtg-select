<?php

namespace App\Filament\Resources\SetResource\RelationManagers;

use App\Enums\WantStatus;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CardsRelationManager extends RelationManager
{
    protected static string $relationship = 'cards';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height('auto')
                        ->extraImgAttributes(['class' => 'w-full'])
                        ->alignCenter()
                        ->searchable(['name', 'oracle_text', 'type_line']),
                    Tables\Columns\ImageColumn::make('reverse_image')
                        ->height('auto')
                        ->extraImgAttributes(['class' => 'w-full'])
                        ->alignCenter(),
                    TextColumn::make('quantity')
                        ->formatStateUsing(fn(int $state) => $state > 1 ? "Count: " . $state : 'Count: 1')
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('foil')
                        ->formatStateUsing(fn(bool $state) => $state ? 'Foil' : 'Not Foil')
                        ->badge()
                        ->color(fn(bool $state) => $state ? 'primary' : 'grey')
                        ->alignCenter(),
                ]),
            ])->contentGrid(function (Table $table) {
                return [
                    'md' => 2,
                    'lg' => 3,
                    '2xl' => 4,
                ];
            })
            ->filters([
                //
            ])
            ->headerActions([
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
                    ->action(fn(Card $record) => Auth::user()->reallyWant($record)),
                Tables\Actions\Action::make('reallyReallyWant')
                    ->label(fn() => WantStatus::ReallyReallyWant->value)
                    ->button()
                    ->outlined(fn(Card $record) => $record->getStatusFor(Auth::user()) !== WantStatus::ReallyReallyWant)
                    ->color('danger')
                    ->action(fn(Card $record) => Auth::user()->reallyReallyWant($record)),
            ])
            ->bulkActions([
            ]);
    }
}
