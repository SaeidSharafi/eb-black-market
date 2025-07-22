<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketListingController extends Controller
{
    public function index()
    {
        return view('market-listings.index');
    }
}
