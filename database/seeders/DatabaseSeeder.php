<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::updateOrCreate(
            ['login' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => 'adm1234'
            ]
        );

        $this->call([
            DeviceSeeder::class,
        ]);
    }
}
