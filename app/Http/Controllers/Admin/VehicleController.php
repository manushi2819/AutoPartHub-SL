<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $vehicles = Vehicle::with(['brand', 'images'])->get();
        return view('AdminDashboard.Vehicles.index', compact('vehicles'));
    }

    // ================= CREATE =================
    public function create()
    {
        $brands = Brand::where('status', 1)->get();
        return view('AdminDashboard.Vehicles.create', compact('brands'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $vehicle = Vehicle::with('images')->findOrFail($id);
        $brands = Brand::where('status', 1)->get();

        return view('AdminDashboard.Vehicles.create', compact('vehicle', 'brands'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id'     => 'required|exists:brands,id',
            'model'        => 'nullable|string|max:255',
            'year'         => 'nullable|integer',
            'price'        => 'required|numeric',
            'mileage'      => 'nullable|integer',
            'condition'    => 'required|string',
            'fuel_type'    => 'nullable|string',
            'transmission' => 'nullable|string',
            'engine_cc'    => 'nullable|integer',
            'body_type'    => 'nullable|string',
            'color'        => 'nullable|string',
            'district'     => 'nullable|string',
            'city'         => 'nullable|string',
            'description'  => 'nullable|string',
            'status'       => 'required|boolean',
        ]);

        $vehicle = Vehicle::create($data);

       return redirect()->route('admin.vehicles.edit', $vehicle->id)
            ->with('success', 'Vehicle created successfully! Now you can upload images.');
    }

    // ================= UPDATE =================
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'brand_id'     => 'required|exists:brands,id',
            'model'        => 'required|string|max:255',
            'year'         => 'required|integer',
            'price'        => 'required|numeric',
            'mileage'      => 'nullable|integer',
            'condition'    => 'required|string',
            'fuel_type'    => 'nullable|string',
            'transmission' => 'nullable|string',
            'engine_cc'    => 'nullable|integer',
            'body_type'    => 'nullable|string',
            'color'        => 'nullable|string',
            'district'     => 'nullable|string',
            'city'         => 'nullable|string',
            'description'  => 'nullable|string',
            'status'       => 'required|boolean',
        ]);

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        foreach ($vehicle->images as $img) {
            if (File::exists(public_path('uploads/' . $img->image_url))) {
                File::delete(public_path('uploads/' . $img->image_url));
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted.');
    }

    // ================= UPLOAD IMAGES =================
    public function uploadImages(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        if ($request->hasFile('images')) {
            $first = true;

            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $filename);

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_url'  => $filename,
                    'is_main'    => $first,
                ]);

                $first = false;
            }
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    // ================= DELETE IMAGE =================
    public function deleteImage(Request $request, $id)
    {
        $image = VehicleImage::findOrFail($id);

        if (File::exists(public_path('uploads/' . $image->image_url))) {
            File::delete(public_path('uploads/' . $image->image_url));
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}