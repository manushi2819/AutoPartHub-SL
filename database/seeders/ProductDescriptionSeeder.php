<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDescriptionSeeder extends Seeder
{
    public function run()
    {
        $products = [
            11 => [
                'small_description' => 'High-strength pistons designed for extreme performance and durability.',
                'description' => 'Forged pistons are built using high-pressure forging processes, making them stronger than cast pistons. Ideal for high-performance and turbocharged engines. Handles high pressure and heat, improves engine durability, and offers long lifespan under stress.'
            ],
            12 => [
                'small_description' => 'Heavy-duty thermostat designed for trucks to regulate engine temperature efficiently.',
                'description' => 'Truck thermostats are built to withstand higher loads and maintain optimal cooling in large engines. They prevent overheating, improve efficiency, and ensure stable engine operation.'
            ],
            13 => [
                'small_description' => 'Brake pads made with metal compounds for strong braking performance.',
                'description' => 'Semi-metallic brake pads provide excellent heat resistance and braking power. They are durable, long-lasting, and suitable for demanding driving conditions.'
            ],
            14 => [
                'small_description' => 'Original equipment manufacturer wheel designed for perfect fit and reliability.',
                'description' => 'OEM wheels are built to manufacturer specifications, ensuring compatibility, durability, and consistent performance for everyday driving.'
            ],
            15 => [
                'small_description' => 'Premium seats designed with leather for comfort and luxury.',
                'description' => 'Leather seats enhance vehicle interiors with a premium feel, offering comfort, durability, and easy maintenance for long-term use.'
            ],
            16 => [
                'small_description' => 'Custom panels designed for style and personalization.',
                'description' => 'Custom panels improve vehicle aesthetics and allow personalization with various materials and designs for interior or exterior upgrades.'
            ],
            17 => [
                'small_description' => 'Reliable automotive battery for starting and powering electrical systems.',
                'description' => 'Lead-acid batteries provide consistent power, are cost-effective, and widely used in most vehicles for reliable performance.'
            ],
            18 => [
                'small_description' => 'Seals the valve cover to prevent oil leaks in the engine.',
                'description' => 'Valve cover gaskets ensure a tight seal, preventing oil leaks and maintaining engine cleanliness under high temperatures.'
            ],
            19 => [
                'small_description' => 'Side mirror adjusted manually without electronic controls.',
                'description' => 'Manual mirrors are durable, simple, and cost-effective, requiring no electrical components and minimal maintenance.'
            ],
            20 => [
                'small_description' => 'Factory-standard pipes designed for reliable performance and fit.',
                'description' => 'OEM pipes ensure proper flow and compatibility, maintaining original vehicle performance and durability.'
            ],
            21 => [
                'small_description' => 'Side mirror adjusted manually without electronic controls.',
                'description' => 'Manual mirrors are durable, simple, and cost-effective, requiring no electrical components and minimal maintenance.'
            ],
        ];

        foreach ($products as $id => $data) {
            DB::table('products')
                ->where('id', $id)
                ->update($data);
        }
    }
}