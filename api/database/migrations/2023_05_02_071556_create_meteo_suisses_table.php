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
        Schema::create('meteo_suisses', function (Blueprint $table) {
            $table->id();
            $table->float('wind');
            $table->float('gust');
            $table->float('temperature');
            $table->float('precipitation');
            $table->dateTime('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meteo_suisses');
    }
};
