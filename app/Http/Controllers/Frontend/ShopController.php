<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class ShopController extends Controller
{

    public function index() {
        return view('Frontend.shop');
    }

   
}
