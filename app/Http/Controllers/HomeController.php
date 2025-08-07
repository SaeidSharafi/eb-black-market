<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $listings = $this->homeService->getLatestListings();
        $heroData = $this->homeService->getHeroData();
        $listingsData = $this->homeService->getListingsData();
        $faqData = $this->homeService->getFaqData();

        return view('home', compact('listings', 'heroData', 'listingsData', 'faqData'));
    }
}
