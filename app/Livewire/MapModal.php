<?php

namespace App\Livewire;

use Livewire\Component;

class MapModal extends Component
{
    public $selectedDriverId;
    public $coordinates = [];

    protected $listeners = ['showMap'];

    public function showMap($driverId)
    {
        $this->selectedDriverId = $driverId;
        $this->loadDriverCoordinates();
        $this->dispatchBrowserEvent('openMapModal');
    }

    public function loadDriverCoordinates()
    {
        // Fetch the driver's coordinates from the database based on $selectedDriverId
        $driver = Driver::find($this->selectedDriverId);

        // Assuming you have a related locations table with latitude and longitude fields
        $this->coordinates = $driver->locations->map(function ($location) {
            return [$location->latitude, $location->longitude];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.map-modal');
    }
}
