<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\CustomerActivity;
use Illuminate\Support\Facades\Mail;

class VehicleController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Vehicle::with(['brand', 'images'])
            ->where('status', 1); // ✅ ONLY ACTIVE

        if(request('brand')){
            $query->whereHas('brand', function($q){
                $q->where('name', request('brand'));
            });
        }

        if(request('model')){
            $query->where('model', request('model'));
        }

        if(request('year')){
            $query->where('year', request('year'));
        }

        if(request('district')){
            $query->where('district', request('district'));
        }

        if(request('condition')){
            $query->where('condition', request('condition'));
        }

        if(request('min_price')){
            $query->where('price', '>=', request('min_price'));
        }

        if(request('max_price')){
            $query->where('price', '<=', request('max_price'));
        }

        $vehicles = $query->latest()->paginate(12);

        // ================= DATA =================

        $vehicles = $query->paginate(12)->withQueryString();

        $brands = Brand::all();
        $models = Vehicle::select('model')->distinct()->pluck('model');
        $years = Vehicle::select('year')->distinct()->pluck('year');
        $fuelTypes = Vehicle::select('fuel_type')->distinct()->pluck('fuel_type');
        $brands = Brand::all();
        $fuelTypes = Vehicle::select('fuel_type')->distinct()->pluck('fuel_type');

        // Sri Lanka Districts
        $districts = [
            'Colombo','Gampaha','Kalutara',
            'Kandy','Matale','Nuwara Eliya',
            'Galle','Matara','Hambantota',
            'Jaffna','Kilinochchi','Mannar','Vavuniya','Mullaitivu',
            'Batticaloa','Ampara','Trincomalee',
            'Kurunegala','Puttalam',
            'Anuradhapura','Polonnaruwa',
            'Badulla','Monaragala',
            'Ratnapura','Kegalle'
        ];

        // Vehicle Conditions
        $conditions = ['New', 'Used', 'Reconditioned'];

        // ================= CUSTOMER ACTIVITY =================

        if(auth('customer')->check())
        {
            // Search tracking
            if($request->filled('model')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'vehicle_search',
                    'value' => $request->model
                ]);
            }

            // Brand tracking
            if($request->filled('brand')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'vehicle_brand_view',
                    'value' => $request->brand
                ]);
            }

            //location tracking
            if($request->filled('district')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'vehicle_location_view',
                    'value' => $request->district
                ]);
            }

             // condition tracking
             if($request->filled('condition')){
                CustomerActivity::create([
                    'customer_id' => auth('customer')->id(),
                    'activity_type' => 'vehicle_condition_view',
                    'value' => $request->condition
                ]);
            }
        }

        return view('Frontend.vehicles', compact(
            'vehicles','brands','models','years','fuelTypes','districts','conditions'
        ));
    }


    public function show($id)
    {
        $vehicle = Vehicle::with(['brand', 'images'])->findOrFail($id);

        // ================= CUSTOMER ACTIVITY =================
        if(auth('customer')->check()){
            CustomerActivity::create([
                'customer_id' => auth('customer')->id(),
                'activity_type' => 'vehicle_view',
                'value' => $vehicle->id
            ]);
        }

        // ================= SIMILAR VEHICLES =================
        $similarVehicles = Vehicle::where('id', '!=', $vehicle->id)
            ->where('brand_id', $vehicle->brand_id)
            ->whereBetween('price', [
                $vehicle->price * 0.8,
                $vehicle->price * 1.2
            ])
            ->where('fuel_type', $vehicle->fuel_type)
            ->whereBetween('year', [
                $vehicle->year - 2,
                $vehicle->year + 2
            ])
            ->with('images', 'brand')
            ->latest()
            ->take(4)
            ->get();

        return view('Frontend.vehicle-details', compact('vehicle', 'similarVehicles'));
    }


    public function sendInquiry(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'district' => 'required',
            'phone' => 'required',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $vehicleLink = route('Frontend.vehicle.details', $vehicle->id); 

        Mail::raw("
        New Vehicle Inquiry

        Vehicle: {$vehicle->brand->name} {$vehicle->model}
        Vehicle Link: {$vehicleLink}
        Name: {$request->name}
        Email: {$request->email}
        District: {$request->district}
        Phone: {$request->phone}
        Message: {$request->message}
            ", function($message){
                $message->to('manuw2819@gmail.com')
                        ->subject('New Vehicle Inquiry');
            });

        return back()->with('success', 'Inquiry sent successfully!');
    }

}