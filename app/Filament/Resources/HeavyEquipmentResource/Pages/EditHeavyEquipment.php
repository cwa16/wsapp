<?php

namespace App\Filament\Resources\HeavyEquipmentResource\Pages;

use App\Filament\Resources\HeavyEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeavyEquipment extends EditRecord
{
    protected static string $resource = HeavyEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
