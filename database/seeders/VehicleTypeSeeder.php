<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Car',
            'Motorbike',
            'Van',
            'Lorry',
            'Bus',
            'Three Wheeler'
        ];

        foreach ($types as $type) {
            VehicleType::create([
                'name' => $type,
                'status' => 1
            ]);
        }
    }
}