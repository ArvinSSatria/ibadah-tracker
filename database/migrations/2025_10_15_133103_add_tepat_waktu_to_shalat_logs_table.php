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
        Schema::table('shalat_logs', function (Blueprint $table) {
            $table->boolean('tepat_waktu')->default(false)->after('berjamaah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shalat_logs', function (Blueprint $table) {
            //
        });
    }
};
