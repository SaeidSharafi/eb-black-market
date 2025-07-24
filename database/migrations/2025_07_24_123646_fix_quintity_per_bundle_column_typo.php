<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('market_listings', function (Blueprint $table) {
            $table->renameColumn('quintity_per_bundle', 'quantity_per_bundle');
        });
    }
};
