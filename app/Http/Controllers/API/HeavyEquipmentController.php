<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coordinate;
use App\Models\Driver;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HeavyEquipmentController extends Controller
{
    public function index($id)
    {
        $data = DB::table('heavy_equipment')->where('asset_code', $id)->first();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $eqId = $request->heavy_equipment_id;
        $nik = $request->nik;
        $activity = $request->activity;
        $from = $request->from;
        $startHour = Carbon::now()->toDateTimeString();

        $data = Driver::create([
            'heavy_equipment_id' => $eqId,
            'nik' => $nik,
            'activity' => $activity,
            'from' => $from,
            'start_hour' => $startHour,
        ]);

        return response()->json([
            'success' => 'Data tersimpan',
        ], 200);

    }

    public function storeFromOffline(Request $request)
    {
        $eqId = $request->heavy_equipment_id;
        $nik = $request->nik;
        $activity = $request->activity;
        $start = $request->start;
        $destination = $request->destination;
        $finish = $request->finish;
        $startHour = $request->start_hour;
        $finishHour = $request->finish_hour;

        $startH = Carbon::parse($startHour);
        $endH = Carbon::parse($finishHour);
        $total_hour = $startH->diffInHours($endH);

        $prestasi = $request->remark;

        $data = Driver::create([
            'heavy_equipment_id' => $eqId,
            'nik' => $nik,
            'activity' => $activity,
            'start' => $start,
            'destination' => $destination,
            'finish' => $finish,
            'start_hour' => $startHour,
            'finish_hour' => $finishHour,
            'total_hour' => $total_hour,
            'remark' => $prestasi,
        ]);

        // \Log::error('hasil: ' . json_encode($request->coordinates['coordinates']));

        foreach ($request->coordinates['coordinates'] as $item) {
            Coordinate::create([
                'driver_id' => $data->id, // Assuming the coordinates have a foreign key 'trip_id'
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
            ]);
        }

        return response()->json([
            'success' => 'Data tersimpan',
        ], 200);

    }

    public function onGoingWork($id)
    {
        $data = Driver::with('HeavyEquipment')->where('nik', $id)->latest()->first();

        return response()->json($data);
    }

    public function finishWorkList($id)
    {
        $data = Driver::with('HeavyEquipment')->where('nik', $id)->whereNotNull('finish_hour')->latest()->get();

        return response()->json($data);
    }

    public function finishWork(Request $request)
    {
        $idDriver = $request->id;
        $to = $request->to;
        $finish_hour = Carbon::now()->toDateTimeString();
        $start_hour = $request->start_hour;

        $start = Carbon::parse($start_hour);
        $end = Carbon::parse($finish_hour);
        $total_hour = $start->diffInHours($end);

        $prestasi = $request->prestasi;

        $data = Driver::where('id', $idDriver)->update([
            'to' => $to,
            'finish_hour' => $finish_hour,
            'remark' => $prestasi,
            'total_hour' => $total_hour,
        ]);

        return response()->json($data, 200);
    }
}
