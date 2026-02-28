<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVehicleCompatibility;

class HomeController extends Controller
{

    public function index() {

       // -------------------------
        // Get unique dropdown values
        // -------------------------
        $years = ProductVehicleCompatibility::select('year_from')
            ->distinct()
            ->orderBy('year_from', 'desc')
            ->pluck('year_from');

        $brands = ProductVehicleCompatibility::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $models = ProductVehicleCompatibility::select('model')
            ->distinct()
            ->orderBy('model')
            ->pluck('model');

        $engines = ProductVehicleCompatibility::select('engine_cc')
            ->distinct()
            ->orderBy('engine_cc')
            ->pluck('engine_cc');

        $fuelTypes = ProductVehicleCompatibility::select('fuel_type')
            ->distinct()
            ->pluck('fuel_type');

        $engineTypes = ProductVehicleCompatibility::select('engine_type')
            ->distinct()
            ->pluck('engine_type');

        return view('Frontend.index', compact(
            'years',
            'brands',
            'models',
            'engines',
            'fuelTypes',
            'engineTypes',
        ));

    }

     public function about() {
        return view('Frontend.about');
    }

     public function contact() {
        return view('Frontend.contact');
    }

   
}
