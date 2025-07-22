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
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('average_price_qrk', 15, 2)->nullable();
            $table->decimal('average_price_not', 15, 2)->nullable();
            $table->decimal('average_price_ton', 15, 2)->nullable();
            $table->decimal('average_price_usd', 15, 2)->nullable();
            $table->integer('total_listed')->nullable();
            $table->timestamp('last_listed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['average_price_qrk', 'average_price_not', 'average_price_ton', 'average_price_usd', 'total_listed', 'last_listed_at']);
        });
    }
};
