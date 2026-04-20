<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{

    public function login() {
        return view('Frontend.login');
    }

     public function register() {
        return view('Frontend.register');
    }
   

    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to get the customer by email first
        $customer = \App\Models\Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->with('error', 'Invalid email or password.');
        }

        // Check if customer is active
        if (!$customer->status) {
            return back()->with('error', 'Your account is inactive. Please contact support.');
        }

        // Attempt login
        if (Auth::guard('customer')->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('Frontend.index')->with('success', 'Logged in successfully.');
        }

        return back()->with('error', 'Invalid email or password.');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:customers,email',
            'phone'      => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('Frontend.login')
            ->with('success', 'Account created successfully. Please login.');
    }


    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('Frontend.login')->with('success', 'logged out successfully.'); 
    }



    //google login
  
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

   public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $customer = Customer::where('email', $googleUser->getEmail())->first();

        if (!$customer) {

            $fullName = $googleUser->getName();
            $nameParts = explode(' ', $fullName);

            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            $customer = Customer::create([
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $googleUser->getEmail(),
                'password'   => bcrypt('random_password'),
                'status'     => 1
            ]);
        }

        Auth::guard('customer')->login($customer);

        return redirect()->route('Frontend.index');
    }
}
