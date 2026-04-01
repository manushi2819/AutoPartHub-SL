<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{

    // Display all customers
    public function index()
    {
        $customers = Customer::withCount('orders')->get(); 
        return view('AdminDashboard.Customer.index', compact('customers'));
    }

    // Update customer status
    public function updateStatus(Request $request, Customer $customer)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $customer->status = $request->status;
        $customer->save();

        return redirect()->route('admin.customers.index')->with('success', 'Customer status updated successfully.');
    }


}