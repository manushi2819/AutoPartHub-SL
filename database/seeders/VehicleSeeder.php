<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::insert([
            [
                'brand_id'      => 2, // Honda
                'model'         => 'Starlet',
                'year'          => 1998,
                'price'         => 2500000,
                'mileage'       => 128000,
                'condition'     => 'Used',
                'fuel_type'     => 'Petrol',
                'transmission'  => 'Automatic',
                'engine_cc'     => 1300,
                'body_type'     => 'Hatchback',
                'color'         => 'White',
                'district'      => 'Kurunegala',
                'city'          => 'Ridigama',
                'description'   => 'Well-maintained Toyota Starlet with good fuel economy. Clean interior and smooth engine condition.',
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'brand_id'      => 2, // Honda
                'model'         => 'Civic EK3',
                'year'          => 1997,
                'price'         => 2850000,
                'mileage'       => 165000,
                'condition'     => 'Used',
                'fuel_type'     => 'Petrol',
                'transmission'  => 'Automatic',
                'engine_cc'     => 1500,
                'body_type'     => 'Sedan',
                'color'         => 'Red',
                'district'      => 'Kurunegala',
                'city'          => 'Ridigama',
                'description'   => 'Honda Civic EK3 in excellent running condition. Original interior with AC and power options.',
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            [
                'brand_id'      => 2, // Honda
                'model'         => 'Civic EG8',
                'year'          => 1995,
                'price'         => 3000000,
                'mileage'       => 182000,
                'condition'     => 'Used',
                'fuel_type'     => 'Petrol',
                'transmission'  => 'Manual',
                'engine_cc'     => 1500,
                'body_type'     => 'Sedan',
                'color'         => 'Blue',
                'district'      => 'Kurunegala',
                'city'          => 'Ridigama',
                'description'   => 'Honda Civic EG8 with manual transmission. Well looked after and ideal for daily driving.',
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}