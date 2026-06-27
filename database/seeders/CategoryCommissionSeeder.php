<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryCommissionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // 🔥 HIGH MARGIN (10 - 15%)
            'Car Audio Systems' => 12,
            'Car DVR' => 12,
            'GPS & In-Car Technology' => 12,
            'Car Tuning & Styling' => 15,
            'Stickers' => 15,
            'Lighting & Indicators' => 12,
            'External Lights & Indicators' => 12,
            'Reverse Camera' => 12,

            // ⚙️ MEDIUM MARGIN (6 - 10%)
            'Air Conditioning & Heating' => 8,
            'Air Intake & Fuel Delivery' => 8,
            'Brakes' => 7,
            'Engine Cooling' => 8,
            'Engines & Engine Parts' => 7,
            'Exhausts & Exhaust Parts' => 8,
            'Transmission & Drivetrain' => 7,
            'Suspension, Steering & Handling' => 7,
            'Turbos & Superchargers' => 9,
            'Starter Motors' => 7,
            'Water Pumps' => 7,
            'Battery' => 6,
            'Axles & Axle Parts' => 7,
            'Carburetor' => 8,
            'Gauges, Dials & Instruments' => 9,

            // 🧰 LOW MARGIN (3 - 6%)
            'Oils, Lubricants & Fluids' => 4,
            'Service Kits' => 5,
            'Wheels, Tyres & Rims' => 5,
            'Windscreen Wipers & Washers' => 4,
            'Mirrors' => 5,
            'Chassis' => 6,
            'Electrical Components' => 6,
            'Footrests, Pedals & Pegs' => 5,
            'Handlebars, Grips & Levers' => 5,
            'Interior Parts & Furnishings' => 6,
            'External & Body Parts' => 6,
            'Emission Systems' => 6,

            // ⚠️ SPECIAL
            'Other' => 3,
            'Freezer' => 3,
            'Solar Panels' => 3,
            'Helmets, Clothing & Protection' => 5,

        ];

        foreach ($categories as $name => $commission) {

            Category::where('name', $name)->update([
                'vendor_commission_percentage' => $commission
            ]);
        }
    }
}