<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class CartController extends Controller
{

    public function index() {
        return view('Frontend.cart');
    }

   public function checkout() {
        return view('Frontend.checkout');
    }
   
}
