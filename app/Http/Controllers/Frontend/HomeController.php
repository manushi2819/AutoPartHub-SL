<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function index() {
        return view('Frontend.index');
    }

     public function about() {
        return view('Frontend.about');
    }

     public function contact() {
        return view('Frontend.contact');
    }

   
}
