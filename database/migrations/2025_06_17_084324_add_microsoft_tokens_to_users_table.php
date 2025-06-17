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
        Schema::table('users', function (Blueprint $table) {
            $table->text('microsoft_access_token')->nullable();
            $table->text('microsoft_refresh_token')->nullable();
            $table->integer('microsoft_token_expiry')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'microsoft_access_token',
                'microsoft_refresh_token',
                'microsoft_token_expiry',
            ]);
        });
    }
};
