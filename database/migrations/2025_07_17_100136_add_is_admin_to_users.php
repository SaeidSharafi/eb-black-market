<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
            $table->boolean('is_super_admin')->default(false)->after('is_admin');
            $table->string('locale', 10)->default('en')->after('is_super_admin');
            $table->string('timezone', 50)->default('UTC')->after('locale');
            $table->string('theme', 50)->default('light')->after('timezone');
            $table->string('color', 50)->default('#000000')->after('theme');
            $table->string('avatar', 255)->nullable()->after('color');
            $table->string('telegram_username', 50)->nullable()->after('avatar');
        });
    }
};
