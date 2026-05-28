<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;

class AdminUserController extends Controller
{
    
    public function index()
    {
        $users = AdminUser::latest()->get();
        return view('AdminDashboard.Users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admin_users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
            'status'   => 'required',
        ]);
        AdminUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);
        return redirect()->back()->with('success', 'Admin User Created Successfully');
    }


    public function update(Request $request, $id)
    {
        $user = AdminUser::findOrFail($id);
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:admin_users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'status' => 'required',
        ]);
        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => $request->status,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->back()->with('success', 'Admin User Updated Successfully');
    }


    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Admin User Deleted Successfully');
    }
}