<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeavyEquipmentResource\Pages;
use App\Filament\Resources\HeavyEquipmentResource\RelationManagers;
use App\Models\HeavyEquipment;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class HeavyEquipmentResource extends Resource
{
    protected static ?string $model = HeavyEquipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('asset_code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('register_no')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year_of_purchase')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status_pembelian')
                    ->required()
                    ->options([
                        'baru' => 'Baru',
                        'bekas' => 'Bekas',
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_code'),
                Tables\Columns\TextColumn::make('register_no'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('year_of_purchase')->sortable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('status_pembelian')->searchable(),
                ImageColumn::make('image')
                    ->square(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DriversRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeavyEquipment::route('/'),
            'create' => Pages\CreateHeavyEquipment::route('/create'),
            'edit' => Pages\EditHeavyEquipment::route('/{record}/edit'),
        ];
    }
}
