<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $devices = Device::query()
            ->select(['id', 'name', 'type', 'status', 'latitude', 'longitude'])
            ->whereBetween('latitude', [-85.05112878, 85.05112878])
            ->whereBetween('longitude', [-180, 180])
            ->orderBy('name')
            ->get();

        return Inertia::render('Dashboard', [
            'devices' => $devices,
        ]);
    }
}
