<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVehicleCompatibility;

class MotorbikeProductSeeder extends Seeder
{
    public function run(): void
    {
        $motorbikeTypeId = 2; // make sure this is correct

        $products = [
            [
                'name' => 'Motorbike Chain Set',
                'price' => 8500,
                'brand' => 'Honda',
                'model' => 'CBR 150',
                'engine_cc' => 150
            ],
            [
                'name' => 'Disc Brake Pads (Bike)',
                'price' => 2500,
                'brand' => 'Yamaha',
                'model' => 'FZ-S',
                'engine_cc' => 150
            ],
            [
                'name' => 'Motorcycle Engine Oil 10W-40',
                'price' => 3200,
                'brand' => 'Bajaj',
                'model' => 'Pulsar 150',
                'engine_cc' => 150
            ],
            [
                'name' => 'Bike Air Filter',
                'price' => 1500,
                'brand' => 'Suzuki',
                'model' => 'Gixxer',
                'engine_cc' => 155
            ],
            [
                'name' => 'Motorbike Clutch Plate Kit',
                'price' => 4200,
                'brand' => 'Honda',
                'model' => 'CD 125',
                'engine_cc' => 125
            ],
            [
                'name' => 'LED Headlight Bulb (Bike)',
                'price' => 1800,
                'brand' => 'Yamaha',
                'model' => 'R15',
                'engine_cc' => 155
            ],
            [
                'name' => 'Motorcycle Battery 12V',
                'price' => 6500,
                'brand' => 'TVS',
                'model' => 'Apache RTR',
                'engine_cc' => 160
            ],
            [
                'name' => 'Bike Spark Plug',
                'price' => 900,
                'brand' => 'Bajaj',
                'model' => 'Discover 125',
                'engine_cc' => 125
            ],
            [
                'name' => 'Motorbike Rear View Mirror Set',
                'price' => 2200,
                'brand' => 'Hero',
                'model' => 'Hunk',
                'engine_cc' => 150
            ],
            [
                'name' => 'Bike Indicator Light Set',
                'price' => 1700,
                'brand' => 'Honda',
                'model' => 'Hornet 160R',
                'engine_cc' => 160
            ],
        ];

        foreach ($products as $index => $item) {

            $product = Product::create([
                'category_id' => 1, // adjust if needed
                'name' => $item['name'],
                'sku' => 'SKU-' . ($index + 1001),
                'brand_id' => null,
                'price' => $item['price'],
                'cost_price' => $item['price'] * 0.7,
                'stock_quantity' => rand(10, 50),
                'status' => 1,
                'description' => $item['name'] . ' suitable for most motorcycles.',
                'small_description' => 'High quality motorbike spare part.',
                'vehicle_type_ids' => [$motorbikeTypeId],
            ]);

            // ✅ Add compatibility
            ProductVehicleCompatibility::create([
                'product_id' => $product->id,
                'brand' => $item['brand'], // stored as name ✔
                'model' => $item['model'],
                'year_from' => 2015,
                'year_to' => 2023,
                'engine_type' => 'Single Cylinder',
                'engine_cc' => $item['engine_cc'],
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
            ]);
        }
    }
}