<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
        public function index()
        {
            return view('seller.profile');
        }
}
