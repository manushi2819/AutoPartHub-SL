<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\AdminUser;

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

        /*
        |--------------------------------------------------------------------------
        | Hardcoded Super Admin Login
        |--------------------------------------------------------------------------
        */
        $hardcodedAdminEmail    = 'admin@example.com';
        $hardcodedAdminPassword = '12345678';

        if (
            $email === $hardcodedAdminEmail &&
            $password === $hardcodedAdminPassword
        ) {

            session([
                'is_admin'      => true,
                'is_super_admin'=> true,
                'admin_id'      => 0,
                'name'          => 'Super Admin',
                'email'         => $hardcodedAdminEmail,
            ]);

            session()->flash('success', 'Successfully logged in as Super Admin.');

            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Users Table Login
        |--------------------------------------------------------------------------
        */
        $adminUser = AdminUser::where('email', $email)->first();

        if (
            $adminUser &&
            Hash::check($password, $adminUser->password)
        ) {

            // Check status
            if ($adminUser->status != 1) {

                return back()->withErrors([
                    'email' => 'Your account is inactive.',
                ])->withInput();
            }

            session([
                'is_admin'       => true,
                'is_super_admin' => false,
                'admin_id'       => $adminUser->id,
                'name'           => $adminUser->name,
                'email'          => $adminUser->email,
            ]);

            session()->flash('success', 'Successfully logged in.');

            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Invalid Credentials
        |--------------------------------------------------------------------------
        */
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
