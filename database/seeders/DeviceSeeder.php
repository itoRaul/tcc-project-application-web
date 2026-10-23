<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            [
                'mac_address' => '04:B2:47:97:8A:F0', //Gateway
                'name'        => 'Gateway Central',
                'type'        => 'GATEWAY',
                'latitude'    => -15.579412,
                'longitude'   => -56.093990,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:98:9C:D0', //No_Sensor
                'name'        => 'Node 01',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -15.579834,
                'longitude'   => -56.093652,
                'status'      => 'ACTIVE',
            ],
        ];

        foreach ($devices as $device) {
            DB::table('devices')->updateOrInsert(
                ['mac_address' => $device['mac_address']],
                array_merge($device, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}