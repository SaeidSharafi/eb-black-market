<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('market_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->integer('quintity_per_bundle')->default(1);
            $table->string('status')->default('active');
            $table->decimal('price_qrk', 16, 4)->nullable();
            $table->decimal('price_not', 16, 4)->nullable();
            $table->decimal('price_ton', 16, 4)->nullable();
            $table->decimal('price_usd', 16, 4)->nullable();
            $table->timestamps();
        });
    }
};
