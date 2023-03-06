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
        Schema::create('user_weather', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('weather')->nullable();
            $table->string('weather_description')->nullable();
            $table->string('base')->nullbale();
            $table->decimal('temp')->nullable();
            $table->decimal('main_temp_min')->nullable();
            $table->decimal('main_temp_max')->nullable();
            $table->integer('main_pressure')->nullable();
            $table->integer('main_humidity')->nullable();
            $table->integer('main_sea_level')->nullable();
            $table->integer('main_grnd_level')->nullable();
            $table->integer('visibility')->nullable();
            $table->decimal('wind_speed')->nullable();
            $table->decimal('wind_deg')->nullable();
            $table->decimal('wind_gust')->nullable();
            $table->integer('sys_sunrise')->nullable();
            $table->integer('sys_sunset')->nullable();
            $table->integer('timezone')->nullable();
            $table->integer('updatedTime')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_weather');
    }
};
