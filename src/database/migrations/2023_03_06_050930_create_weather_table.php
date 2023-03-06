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
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('temp')->nullable();
            $table->string('temp_min')->nullable();            
            $table->string('temp_max')->nullable();
            $table->string('pressure')->nullable();            
            $table->string('humidity')->nullable();
            $table->string('sea_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};