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
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_id')->default('pico_sensor_1'); // client id
            $table->decimal('temperature', 5, 2); // temperature
            $table->decimal('humidity', 5, 2);   // humidity 
            $table->string('topic')->default('sensors/dht'); // topic
            $table->timestamps(); // timestamps
            $table->index('sensor_id'); // sensor id
            $table->index('created_at'); // created at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};

