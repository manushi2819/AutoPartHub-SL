<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class VehicleCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            "Engine Components" => [
                "Pistons" => ["Standard Pistons", "Forged Pistons", "High-Compression Pistons", "Alloy Pistons", "Performance Pistons"],
                "Camshafts" => ["Standard Camshafts", "Performance Camshafts", "Hydraulic Camshafts", "Solid Camshafts", "Race Camshafts"],
                "Gaskets & Seals" => ["Head Gaskets", "Valve Cover Gaskets", "Oil Seals", "Exhaust Gaskets", "Timing Cover Gaskets"],
            ],
            "Suspension & Steering" => [
                "Shock Absorbers" => ["Front Shock Absorbers", "Rear Shock Absorbers", "Gas Shocks", "Hydraulic Shocks", "Performance Shocks"],
                "Control Arms" => ["Front Control Arms", "Rear Control Arms", "Adjustable Control Arms", "Lower Control Arms", "Upper Control Arms"],
                "Steering Racks" => ["Power Steering Racks", "Manual Steering Racks", "Rack & Pinion", "Rebuilt Steering Racks", "Performance Steering Racks"],
            ],
            "Brakes" => [
                "Brake Pads" => ["Ceramic Pads", "Semi-Metallic Pads", "Performance Pads", "OEM Pads", "Truck Pads"],
                "Brake Discs" => ["Vented Discs", "Drilled Discs", "Slotted Discs", "OEM Discs", "Performance Discs"],
                "Brake Lines" => ["Steel Braided Lines", "Rubber Brake Lines", "OEM Brake Lines", "Performance Brake Lines", "Rear Brake Lines"],
            ],
            "Transmission" => [
                "Clutches" => ["Standard Clutch Kit", "Performance Clutch Kit", "Ceramic Clutch", "OEM Clutch", "Truck Clutch"],
                "Flywheels" => ["Lightweight Flywheel", "OEM Flywheel", "Performance Flywheel", "Dual-Mass Flywheel", "Steel Flywheel"],
                "Transmission Fluid" => ["Automatic Transmission Fluid", "Manual Transmission Fluid", "Synthetic ATF", "OEM Transmission Fluid", "High-Performance Fluid"],
            ],
            "Electrical" => [
                "Batteries" => ["Lead-Acid Battery", "AGM Battery", "Lithium-Ion Battery", "Truck Battery", "Motorcycle Battery"],
                "Alternators" => ["Standard Alternator", "High Output Alternator", "OEM Alternator", "Remanufactured Alternator", "Performance Alternator"],
                "Starters" => ["Standard Starter", "High Torque Starter", "OEM Starter", "Rebuilt Starter", "Performance Starter"],
            ],
            "Exhaust" => [
                "Mufflers" => ["Standard Muffler", "Performance Muffler", "OEM Muffler", "Stainless Steel Muffler", "Turbo Muffler"],
                "Catalytic Converters" => ["OEM Catalytic Converter", "High Flow Converter", "Direct Fit Converter", "Universal Converter", "Truck Converter"],
                "Exhaust Pipes" => ["Stainless Steel Pipes", "Aluminized Pipes", "Custom Exhaust Pipes", "OEM Pipes", "Turbo Pipes"],
            ],
            "Fuel System" => [
                "Fuel Pumps" => ["Electric Fuel Pump", "Mechanical Fuel Pump", "High Flow Pump", "OEM Pump", "Performance Pump"],
                "Fuel Injectors" => ["Standard Injector", "High Performance Injector", "OEM Injector", "Throttle Body Injector", "Direct Injection Injector"],
                "Fuel Filters" => ["Inline Fuel Filter", "Cartridge Filter", "OEM Fuel Filter", "High Flow Fuel Filter", "Diesel Fuel Filter"],
            ],
            "Cooling System" => [
                "Radiators" => ["Aluminum Radiator", "OEM Radiator", "Performance Radiator", "Truck Radiator", "Motorcycle Radiator"],
                "Water Pumps" => ["Standard Water Pump", "High Flow Water Pump", "OEM Water Pump", "Performance Water Pump", "Electric Water Pump"],
                "Thermostats" => ["Standard Thermostat", "High Temp Thermostat", "OEM Thermostat", "Performance Thermostat", "Truck Thermostat"],
            ],
            "Body & Exterior" => [
                "Mirrors" => ["Side Mirrors", "Rearview Mirror", "Heated Mirror", "Power Mirror", "Manual Mirror"],
                "Bumpers" => ["Front Bumper", "Rear Bumper", "OEM Bumper", "Performance Bumper", "Custom Bumper"],
                "Lights" => ["Headlights", "Tail Lights", "Fog Lights", "LED Light Bars", "Turn Signals"],
            ],
            "Interior" => [
                "Seats" => ["Standard Seats", "Sports Seats", "Leather Seats", "OEM Seats", "Custom Seats"],
                "Steering Wheels" => ["Standard Wheel", "Sport Wheel", "Leather Wheel", "OEM Wheel", "Custom Wheel"],
                "Dashboard Accessories" => ["Gauges", "Dash Covers", "Cup Holders", "Phone Mounts", "Custom Panels"],
            ],
        ];

        foreach ($categories as $mainName => $subs) {
            $main = Category::create([
                'name' => $mainName,
                'parent_id' => null,
                'status' => 1,
            ]);

            foreach ($subs as $subName => $subsubs) {
                $sub = Category::create([
                    'name' => $subName,
                    'parent_id' => $main->id,
                    'status' => 1,
                ]);

                foreach ($subsubs as $subsubName) {
                    Category::create([
                        'name' => $subsubName,
                        'parent_id' => $sub->id,
                        'status' => 1,
                    ]);
                }
            }
        }
    }
}
