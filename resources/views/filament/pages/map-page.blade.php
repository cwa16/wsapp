<x-filament::page>
    <div id="map"></div>

    <!-- Leaflet JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([-3.6264876338338428, 114.86055265211952], 13); // Default center

            // Add OpenStreetMap tiles to the map
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            document.querySelectorAll('.see-map').forEach(link => {
                link.addEventListener('click', function() {
                    // Clear existing layers if needed
                    map.eachLayer(function(layer) {
                        if (layer instanceof L.Polyline || layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });

                    var latlngs = JSON.parse(this.getAttribute('data-latlngs'));
                    var polyline = L.polyline(latlngs.map(ll => [ll.latitude, ll.longitude]), {
                        color: 'red'
                    }).addTo(map);
                    map.fitBounds(polyline.getBounds());

                    // Calculate and display total distance
                    var totalDistance = 0;
                    for (var i = 1; i < latlngs.length; i++) {
                        var point1 = L.latLng(latlngs[i - 1].latitude, latlngs[i - 1].longitude);
                        var point2 = L.latLng(latlngs[i].latitude, latlngs[i].longitude);
                        totalDistance += point1.distanceTo(point2);
                    }

                    // Convert to kilometers and round to two decimals
                    totalDistance = (totalDistance / 1000).toFixed(2);

                    // Display a popup with the total distance
                    var distancePopup = L.popup()
                        .setLatLng(map.getBounds().getCenter())
                        .setContent('Total Distance: ' + totalDistance + ' km')
                        .openOn(map);


                });
            });



        });
    </script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <!-- Basic HTML Table -->
    <x-filament::card>
        <div class="mb-3">
            <form action="{{ url()->current() }}" method="get">
                <div class="space-y-4 p-4">
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="w-full sm:w-1/2">
                            <label for="heavy_equipment" class="block text-sm font-medium text-gray-700">Nama
                                Alat</label>
                            <select
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                name="equipment_id" id="heavy_equipment">
                                <option value="" disabled>-- Pilih Alat --</option>
                                @foreach ($heavy_equipments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}, {{ $item->type }},
                                        {{ $item->year_of_purchase }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                name="tanggal" id="date">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">

                        <div class="w-full sm:w-1/2 flex items-end">
                            <button type="submit"
                                class="w-full border border-gray-300 bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300 mt-2">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Hari/ Tgl
                        </th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Unit
                        </th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">NIK
                        </th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">Nama
                        </th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Activity</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-center" colspan="3">
                            Trip</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-center" colspan="3">
                            Hour</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Total Rit</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Action</th>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Dari</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Ke</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Selesai</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Awal</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Akhir</th>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"
                    @forelse ($drivers as $driver)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($driver->created_at)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ $driver->HeavyEquipment->name }},{{ $driver->HeavyEquipment->type }},{{ $driver->HeavyEquipment->year_of_purchase }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->nik }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ $driver->user->name }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->activity }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->start }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ $driver->destination }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->finish }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($driver->start_hour)->isoFormat('HH:mm') }} WITA
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($driver->finish_hour)->isoFormat('HH:mm') }} WITA
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ $driver->total_hour }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->remark }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-blue-500 hover:underline">
                                <a href="javascript:void(0)" class="see-map"
                                    data-latlngs='@json($driver->coordinates)'>See Map</a>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center">- Silahkan filter data untuk menampilkan data -</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </x-filament::card>
</x-filament::page>
