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
        Schema::create('meteosuisses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('wind');
            $table->float('gust');
            $table->float('temperature');
            $table->float('precipitation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meteosuisses');
    }
};
