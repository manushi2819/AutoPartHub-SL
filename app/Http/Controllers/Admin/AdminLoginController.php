<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Employee;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('AdminDashboard.login'); 
    }


   public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];

        // Hardcoded admin check
        $hardcodedAdminEmail    = 'admin@example.com';
        $hardcodedAdminPassword = '12345678'; 

        if ($email === $hardcodedAdminEmail && $password === $hardcodedAdminPassword) {
            // Store hardcoded admin session
            session([
                'is_admin' => true,
                'name'     => 'Super Admin',
                'email'    => $hardcodedAdminEmail,
            ]);

            session()->flash('success', 'Successfully logged in as Admin.');
            return redirect()->route('admin.dashboard');
        }

        // Invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }


    
    public function logout(Request $request)
    {
        $request->session()->forget(['is_admin']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
