<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Air Conditioning & Heating',
            'Air Intake & Fuel Delivery',
            'Axles & Axle Parts',
            'Battery',
            'Brakes',
            'Car Audio Systems',
            'Car DVR',
            'Car Tuning & Styling',
            'Carburetor',
            'Chassis',
            'Electrical Components',
            'Emission Systems',
            'Engine Cooling',
            'Engines & Engine Parts',
            'Exhausts & Exhaust Parts',
            'External & Body Parts',
            'External Lights & Indicators',
            'Footrests, Pedals & Pegs',
            'Freezer',
            'Gauges, Dials & Instruments',
            'Generator',
            'GPS & In-Car Technology',
            'Handlebars, Grips & Levers',
            'Helmets, Clothing & Protection',
            'Interior Parts & Furnishings',
            'Lighting & Indicators',
            'Mirrors',
            'Oils, Lubricants & Fluids',
            'Other',
            'Reverse Camera',
            'Seating',
            'Service Kits',
            'Silencer',
            'Solar Panels',
            'Starter Motors',
            'Stickers',
            'Suspension, Steering & Handling',
            'Transmission & Drivetrain',
            'Turbos & Superchargers',
            'Water Pumps',
            'Wheels, Tyres & Rims',
            'Windscreen Wipers & Washers',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'parent_id' => null,
                'status' => 1,
                'image' => null,
            ]);
        }
    }
}