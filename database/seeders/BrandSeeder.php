<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Toyota', 'status' => '1', 'image' => null],
            ['name' => 'Honda', 'status' => '1', 'image' => null],
            ['name' => 'Ford', 'status' => '1', 'image' => null],
            ['name' => 'BMW', 'status' => '1', 'image' => null],
            ['name' => 'Mercedes-Benz', 'status' => '1', 'image' => null],
            ['name' => 'Audi', 'status' => '1', 'image' => null],
            ['name' => 'Nissan', 'status' => '1', 'image' => null],
            ['name' => 'Hyundai', 'status' => '1', 'image' => null],
            ['name' => 'Porsche', 'status' => '1', 'image' => null],
            ['name' => 'Tesla', 'status' => '1', 'image' => null],
            ['name' => 'Suzuki', 'status' => '1', 'image' => null],
            ['name' => 'Jaguar', 'status' => '1', 'image' => null],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}