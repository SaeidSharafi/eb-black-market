<?php

namespace App\Http\Controllers;

use App\Models\MarketListing;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $sitemap .= $this->createUrlEntry(url('/'), now()->toISOString(), 'daily', '1.0');

        // Market listings page
        $sitemap .= $this->createUrlEntry(route('market-listings.index'), now()->toISOString(), 'hourly', '0.9');

        // Dashboard (public pages)
        $sitemap .= $this->createUrlEntry(url('/dashboard'), now()->toISOString(), 'weekly', '0.7');

        // Add individual listings (latest ones)
        $recentListings = MarketListing::with('item')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('created_at')
            ->take(100)
            ->get();

        foreach ($recentListings as $listing) {
            if ($listing->item) {
                $url = route('market-listings.index') . '#listing-' . $listing->id;
                $sitemap .= $this->createUrlEntry(
                    $url,
                    $listing->updated_at->toISOString(),
                    'weekly',
                    '0.6'
                );
            }
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function createUrlEntry($url, $lastmod, $changefreq, $priority)
    {
        return "  <url>\n" .
               "    <loc>" . htmlspecialchars($url) . "</loc>\n" .
               "    <lastmod>" . $lastmod . "</lastmod>\n" .
               "    <changefreq>" . $changefreq . "</changefreq>\n" .
               "    <priority>" . $priority . "</priority>\n" .
               "  </url>\n";
    }
}
