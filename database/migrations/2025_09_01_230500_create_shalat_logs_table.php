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
        Schema::create('shalat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('shalat', ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);
            $table->boolean('dilaksanakan')->default(false);
            $table->enum('status', ['tidak shalat', 'tepat waktu', 'diqodho'])->default('tidak shalat');
            $table->boolean('berjamaah')->default(false);
            $table->timestamps();

            // Mencegah entri duplikat untuk user, tanggal, dan shalat yang sama
            $table->unique(['user_id', 'tanggal', 'shalat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shalat_logs');
    }
};
