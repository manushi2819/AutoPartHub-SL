<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class LoginController extends Controller
{

    public function login() {
        return view('Frontend.login');
    }

     public function register() {
        return view('Frontend.register');
    }
   
}
