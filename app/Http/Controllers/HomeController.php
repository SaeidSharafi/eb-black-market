<?php

namespace App\Http\Controllers;

use App\Models\MarketListing;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $listings = MarketListing::with(['item', 'user'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('home', compact('listings'));
    }
}
