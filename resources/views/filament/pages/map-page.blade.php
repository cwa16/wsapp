<x-filament::page>
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
                                    <option value="{{ $item->id }}">{{ $item->asset_code }}, {{ $item->name }},
                                        {{ $item->type }},
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
        <div class="mb-2">
            <ul class="list-none">
                @php
                    $driver = $drivers->first();
                @endphp
                @if ($driver)
                    <li><b>Asset Code:</b> {{ $driver->HeavyEquipment->asset_code }}</li>
                    <li><b>Register No.:</b> {{ $driver->HeavyEquipment->register_no }}</li>
                    <li><b>Name Unit:</b> {{ $driver->HeavyEquipment->name }}</li>
                    <li><b>Type:</b> {{ $driver->HeavyEquipment->type }}</li>
                @endif
            </ul>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300 mt-2">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-left" rowspan="2">
                            Hari/ Tgl
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
                    @php
                        $total_hour = 0;
                        $total_rit = 0;
                    @endphp
                    @forelse ($drivers->get() as $driver)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($driver->created_at)->isoFormat('dddd, D MMMM Y') }}
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
                                {{ \Carbon\Carbon::parse($driver->start_hour)->isoFormat('HH:mm') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($driver->finish_hour)->isoFormat('HH:mm') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                {{ $driver->total_hour }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $driver->remark }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $total_hour += $driver->total_hour;
                                $total_rit += $driver->remark;
                            @endphp
                            <th class="border border-gray-300 px-4 py-2 text-sm text-gray-700" colspan="9">Total</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $total_hour }}</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $total_rit }}</th>
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
