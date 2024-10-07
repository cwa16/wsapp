<?php

namespace App\Http\Controllers;

use App\Filament\Pages\MapPage;

class MapController extends Controller
{
    public function showMapPage()
    {
        $data = [
            'location' => 'New York',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ];

        // Render the MapPage with the data
        return MapPage::make(['data' => $data]);
    }
}
