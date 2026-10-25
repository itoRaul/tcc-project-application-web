<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DevicesController extends Controller
{
    public function index(): Response
    {
        $devices = Device::query()
            ->select(['id', 'mac_address', 'name', 'type', 'latitude', 'longitude', 'status'])
            ->orderBy('id')
            ->get();

        return Inertia::render('Devices', [
            'devices' => $devices,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mac_address' => [
                'required',
                'string',
                'max:17',
                'unique:devices,mac_address',
            ],
            'name' => ['required', 'string', 'max:100'],
            'type' => [
                'required',
                'string',
                Rule::in(['SENSOR_NODE', 'GATEWAY', 'sensor_node', 'gateway']),
            ],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => [
                'required',
                'string',
                Rule::in(['ACTIVE', 'INACTIVE', 'MAINTENANCE', 'active', 'inactive', 'maintenance']),
            ],
        ], [
            'mac_address.required' => 'O endereço MAC é obrigatório.',
            'mac_address.max' => 'O endereço MAC não pode ter mais que 17 caracteres.',
            'mac_address.unique' => 'Este endereço MAC já está cadastrado.',
            'name.required' => 'O nome do dispositivo é obrigatório.',
            'name.max' => 'O nome não pode exceder 100 caracteres.',
            'type.required' => 'O tipo do dispositivo é obrigatório.',
            'type.in' => 'O tipo deve ser Nó Sensor ou Gateway.',
            'latitude.required' => 'A latitude é obrigatória.',
            'latitude.numeric' => 'A latitude deve ser um número válido.',
            'latitude.between' => 'A latitude deve estar entre -90 e 90.',
            'longitude.required' => 'A longitude é obrigatória.',
            'longitude.numeric' => 'A longitude deve ser um número válido.',
            'longitude.between' => 'A longitude deve estar entre -180 e 180.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        $validated['mac_address'] = strtoupper(trim($validated['mac_address']));
        $validated['name'] = trim($validated['name']);
        $validated['type'] = strtoupper(trim($validated['type']));
        $validated['status'] = strtoupper(trim($validated['status']));
        $validated['latitude'] = round((float) $validated['latitude'], 8);
        $validated['longitude'] = round((float) $validated['longitude'], 8);

        Device::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, Device $device): RedirectResponse
    {
        $validated = $request->validate([
            'mac_address' => [
                'required',
                'string',
                'max:17',
                Rule::unique('devices', 'mac_address')->ignore($device->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'type' => [
                'required',
                'string',
                Rule::in(['SENSOR_NODE', 'GATEWAY', 'sensor_node', 'gateway']),
            ],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => [
                'required',
                'string',
                Rule::in(['ACTIVE', 'INACTIVE', 'MAINTENANCE', 'active', 'inactive', 'maintenance']),
            ],
        ], [
            'mac_address.required' => 'O endereço MAC é obrigatório.',
            'mac_address.max' => 'O endereço MAC não pode ter mais que 17 caracteres.',
            'mac_address.unique' => 'Este endereço MAC já está cadastrado em outro dispositivo.',
            'name.required' => 'O nome do dispositivo é obrigatório.',
            'name.max' => 'O nome não pode exceder 100 caracteres.',
            'type.required' => 'O tipo do dispositivo é obrigatório.',
            'type.in' => 'O tipo deve ser Nó Sensor ou Gateway.',
            'latitude.required' => 'A latitude é obrigatória.',
            'latitude.numeric' => 'A latitude deve ser um número válido.',
            'latitude.between' => 'A latitude deve estar entre -90 e 90.',
            'longitude.required' => 'A longitude é obrigatória.',
            'longitude.numeric' => 'A longitude deve ser um número válido.',
            'longitude.between' => 'A longitude deve estar entre -180 e 180.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        $validated['mac_address'] = strtoupper(trim($validated['mac_address']));
        $validated['name'] = trim($validated['name']);
        $validated['type'] = strtoupper(trim($validated['type']));
        $validated['status'] = strtoupper(trim($validated['status']));
        $validated['latitude'] = round((float) $validated['latitude'], 8);
        $validated['longitude'] = round((float) $validated['longitude'], 8);

        $device->update($validated);

        return redirect()->back();
    }

    public function destroy(Device $device): RedirectResponse
    {
        $device->delete();

        return redirect()->back();
    }
}

