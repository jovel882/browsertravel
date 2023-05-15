<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        City::create([
            'name' => 'Miami',
            'lat' => 25.7617,
            'lng' => -80.1918,
        ]);

        City::create([
            'name' => 'Orlando',
            'lat' => 28.5383,
            'lng' => -81.3792,
        ]);

        City::create([
            'name' => 'New York',
            'lat' => 40.7128,
            'lng' => -74.006,
        ]);

    }
}
