<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('market_listings', function (Blueprint $table) {
            $table->enum('listing_type', ['buy', 'sell'])
                ->default('sell')
                ->after('status')
                ->comment('Type of listing: buy or sell');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('market_listings', function (Blueprint $table) {
            //
        });
    }
};
