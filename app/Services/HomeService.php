<?php

namespace App\Services;

use App\Models\MarketListing;
use Illuminate\Database\Eloquent\Collection;

class HomeService
{
    public function getLatestListings(int $limit = 10)
    {
        return MarketListing::with(['item', 'user'])
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    public function getFaqData(): array
    {
        return __('resources.home.faq.questions');
    }

    public function getHeroData(): array
    {
        return [
            'title' => __('resources.home.title'),
            'subtitle' => __('resources.home.subtitle'),
            'explore_listings' => __('resources.home.explore_listings'),
            'go_to_dashboard' => __('resources.home.go_to_dashboard'),
            'login' => __('resources.home.login'),
        ];
    }

    public function getListingsData(): array
    {
        return [
            'latest_listings' => __('resources.home.latest_listings'),
            'no_listings' => __('resources.home.no_listings'),
            'view_all_listings' => __('resources.home.view_all_listings'),
            'contact_seller' => __('resources.home.contact_seller'),
            'listed' => __('resources.home.listed'),
            'unknown' => __('resources.home.unknown'),
            'na' => __('resources.home.na'),
        ];
    }
}
