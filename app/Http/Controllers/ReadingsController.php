<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Reading;
use Inertia\Inertia;
use Inertia\Response;

class ReadingsController extends Controller
{
    public function index(): Response
    {
        $readings = Reading::query()
            ->with('device')
            ->orderByDesc('read_at')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('Readings', [
            'readings' => $readings,
        ]);
    }
}
