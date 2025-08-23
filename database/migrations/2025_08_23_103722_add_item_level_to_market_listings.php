<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('market_listings', function (Blueprint $table) {
            $table->integer('item_level')->default(0)->after('item_id');
        });
    }

    public function down(): void
    {
        Schema::table('market_listings', function (Blueprint $table) {
            $table->dropColumn('item_level');
        });
    }
};
