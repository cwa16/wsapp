<?php

namespace App\Filament\Pages;

use App\Models\Coordinate;
use App\Models\Driver;
use App\Models\HeavyEquipment;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MapPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.map-page';

    public function getViewData(): array
    {
        // Get filters from the request (assuming you're passing them via query string or form)
        $equipmentId = request()->input('equipment_id');
        $tanggal = request()->input('tanggal');

        $items = Coordinate::get();
        // dd($items);
        // $drivers = Driver::whereDate('start_hour', $tanggal)->get();

        if (!$tanggal) {
            $drivers = Driver::whereHas('HeavyEquipment', function (Builder $query) use ($equipmentId) {
                $query->where('id', '=', $equipmentId);
            });
        } else {
            $drivers = Driver::whereDate('start_hour', $tanggal)->whereHas('HeavyEquipment', function (Builder $query) use ($equipmentId) {
                $query->where('id', '=', $equipmentId);
            });
        }

        // dd($drivers);
        $heavy_equipements = HeavyEquipment::get();

        // Pass the $items data to the view
        return [
            'items' => $items,
            'drivers' => $drivers,
            'heavy_equipments' => $heavy_equipements,
        ];
    }

}
