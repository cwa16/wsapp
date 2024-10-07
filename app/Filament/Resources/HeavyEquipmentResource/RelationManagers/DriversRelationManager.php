<?php

namespace App\Filament\Resources\HeavyEquipmentResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class DriversRelationManager extends RelationManager
{
    protected static string $relationship = 'drivers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('activity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('start')
                    ->required(),
                Forms\Components\TextInput::make('destination')
                    ->required(),
                Forms\Components\TextInput::make('finish'),
                Forms\Components\DateTimePicker::make('start_hour')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $start = $state ? Carbon::parse($state) : null; // Parse start time as Carbon
                        $end = $get('finish_hour') ? Carbon::parse($get('finish_hour')) : null; // Parse end time as Carbon
                        if ($start && $end) {
                            $diff = $end->diffInHours($start);
                            $set('total_hour', $diff);
                        } else {
                            $set('total_hour', 0);
                        }
                    }),
                Forms\Components\DateTimePicker::make('finish_hour')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $end = $state ? Carbon::parse($state) : null; // Parse end time as Carbon
                        $start = $get('start_hour') ? Carbon::parse($get('start_hour')) : null; // Parse start time as Carbon
                        if ($start && $end) {
                            $diff = $start->diffInHours($end);
                            $set('total_hour', number_format($diff, 0));
                        } else {
                            $set('total_hour', 0);
                        }
                    }),
                Forms\Components\TextInput::make('total_hour')
                    ->label('Total Hours')
                    ->readonly(),
                Forms\Components\TextInput::make('remark')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('driver')
            ->columns([
                Tables\Columns\TextColumn::make('nik'),
                Tables\Columns\TextColumn::make('activity'),
                Tables\Columns\TextColumn::make('start'),
                Tables\Columns\TextColumn::make('destination'),
                Tables\Columns\TextColumn::make('finish'),
                Tables\Columns\TextColumn::make('start_hour'),
                Tables\Columns\TextColumn::make('finish_hour'),
                Tables\Columns\TextColumn::make('total_hour'),
                Tables\Columns\TextColumn::make('remark'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('map')
                    ->label('Show Map')
                    ->icon('heroicon-o-map')
                    ->action(function ($record) {
                        $this->dispatch('showMap', $record->id); // Emit the event to open the modal with map
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
