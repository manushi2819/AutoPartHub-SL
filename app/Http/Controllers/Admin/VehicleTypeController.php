<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::all();
        return view('AdminDashboard.VehicleType.index', compact('vehicleTypes'));
    }


    public function store(Request $request)
    {
        VehicleType::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return back()->with('success', 'Vehicle Type created');
    }


    public function update(Request $request, $id)
    {
        $type = VehicleType::findOrFail($id);

        $type->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return back()->with('success', 'Vehicle Type updated');
    }


    public function destroy($id)
    {
        VehicleType::findOrFail($id)->delete();

        return back()->with('success', 'Vehicle Type deleted');
    }
}