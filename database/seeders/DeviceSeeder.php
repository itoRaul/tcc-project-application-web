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
                'mac_address' => '04:B2:47:97:8A:01',
                'name'        => 'Gateway Central',
                'type'        => 'GATEWAY',
                'latitude'    => -12.085000,
                'longitude'   => -45.785000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:02',
                'name'        => 'Node North Border 01',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.080000,
                'longitude'   => -45.785000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:03',
                'name'        => 'Node North Border 02',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.080000,
                'longitude'   => -45.780000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:04',
                'name'        => 'Node East Border 01',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.080000,
                'longitude'   => -45.775000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:05',
                'name'        => 'Node East Border 02',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.085000,
                'longitude'   => -45.775000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:06',
                'name'        => 'Node South Border 01',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.090000,
                'longitude'   => -45.775000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:07',
                'name'        => 'Node South Border 02',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.090000,
                'longitude'   => -45.780000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:08',
                'name'        => 'Node West Border 01',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.090000,
                'longitude'   => -45.785000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:09',
                'name'        => 'Node West Border 02',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.085000,
                'longitude'   => -45.788000,
                'status'      => 'ACTIVE',
            ],
            [
                'mac_address' => '04:B2:47:97:8A:10',
                'name'        => 'Node Refuge Area',
                'type'        => 'SENSOR_NODE',
                'latitude'    => -12.082500,
                'longitude'   => -45.787000,
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