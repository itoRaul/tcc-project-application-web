<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Reading;
use App\Models\Alert;

class ApiController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mac_address'   => 'required|string|max:17',
            'weevil_count'  => 'required|integer|min:0',
            'battery_level' => 'required|numeric|min:0|max:100',
            'rssi'          => 'nullable|integer',
        ]);

        $device = Device::where('mac_address', $validated['mac_address'])->first();

        if (!$device) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Device not registered with MAC: ' . $validated['mac_address'],
            ], 404);
        }

        $reading = Reading::create([
            'device_id'     => $device->id,
            'weevil_count'  => $validated['weevil_count'],
            'battery_level' => $validated['battery_level'],
            'rssi'          => $validated['rssi'] ?? null,
            'read_at'       => now(),
        ]);

        if ($validated['weevil_count'] >= 10) {
            Alert::create([
                'device_id'   => $device->id,
                'alert_type'  => 'HIGH_INFESTATION',
                'message'     => "Critical infestation detected at {$device->name}: {$validated['weevil_count']} weevils.",
                'is_resolved' => false,
            ]);
        }

        if ($validated['battery_level'] <= 20.0) {
            Alert::create([
                'device_id'   => $device->id,
                'alert_type'  => 'LOW_BATTERY',
                'message'     => "Low battery on {$device->name}: {$validated['battery_level']}%.",
                'is_resolved' => false,
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Reading saved successfully',
            'data'    => $reading,
        ], 201);
    }
}