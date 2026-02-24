<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('buyer.profile');
    }
}
