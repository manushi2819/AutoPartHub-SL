<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVehicleCompatibility;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get all categories (only leaf categories for product assignment)
        $categories = Category::whereHas('children', function($q){}, '<', 1)->get();

        // Sample brands, models, engines, fuel types, engine types
        $brands = ['Toyota', 'Honda', 'Nissan', 'Mazda', 'Mitsubishi'];
        $models = ['Corolla', 'Civic', 'Altima', 'Mazda3', 'Lancer'];
        $engine_ccs = [1000, 1300, 1500, 1800, 2000];
        $fuel_types = ['Petrol', 'Diesel', 'Hybrid'];
        $engine_types = ['Inline', 'V-Type', 'Rotary'];

        for ($i = 1; $i <= 20; $i++) {

            // Random category from leaf categories
            $category = $categories->random();

            // Create Product
            $product = Product::create([
                'category_id' => $category->id,
                'name' => "Product $i - " . $category->name,
                'sku' => 'SKU' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'brand' => $brands[array_rand($brands)],
                'price' => rand(5000, 50000),
                'cost_price' => rand(3000, 40000),
                'description' => "This is a description for Product $i.",
                'stock_quantity' => rand(5, 50),
                'status' => 1,
            ]);

            // Add 2 Product Images
            for ($j = 1; $j <= 2; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => "https://via.placeholder.com/400x300?text=Product+$i+Image+$j",
                    'is_main' => $j == 1 ? 1 : 0,
                ]);
            }

            // Add Vehicle Compatibility
            ProductVehicleCompatibility::create([
                'product_id' => $product->id,
                'brand' => $brands[array_rand($brands)],
                'model' => $models[array_rand($models)],
                'year_from' => rand(2005, 2018),
                'year_to' => rand(2019, 2025),
                'engine_cc' => $engine_ccs[array_rand($engine_ccs)],
                'fuel_type' => $fuel_types[array_rand($fuel_types)],
                'engine_type' => $engine_types[array_rand($engine_types)],
                'transmission' => rand(0,1) ? 'Manual' : 'Automatic',
            ]);
        }
    }
}