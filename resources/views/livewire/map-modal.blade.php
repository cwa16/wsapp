<x-filament::modal id="show-map">
    <!-- Modal HTML -->
    <div id="mapModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center">
                <h3 class="text-lg">Driver Route Map</h3>
                <button class="text-black" onclick="closeModal()">X</button>
            </div>

            <div id="map" style="height: 400px; width: 100%;"></div>

            <div class="flex justify-end mt-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="closeModal()">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('openMapModal', function() {
                document.getElementById('mapModal').classList.remove('hidden');

                var map = L.map('map').setView([0, 0], 13); // Default center

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Load coordinates from Livewire component
                var coordinates = @json($coordinates);

                if (coordinates.length > 0) {
                    var latlngs = coordinates.map(function(item) {
                        return [item[0], item[1]];
                    });

                    var polyline = L.polyline(latlngs, {
                        color: 'red'
                    }).addTo(map);
                    map.fitBounds(polyline.getBounds());
                }
            });
        });

        function closeModal() {
            document.getElementById('mapModal').classList.add('hidden');
        }
    </script>
</x-filament::modal>
