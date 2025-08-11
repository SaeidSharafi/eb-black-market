<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Str;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\User::whereNull('telegram_connect_token')->cursor()->each(function (\App\Models\User $user) {
            $user->telegram_connect_token = Str::uuid7();
            $user->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
