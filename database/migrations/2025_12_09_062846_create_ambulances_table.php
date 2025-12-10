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
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->string('ambulance_number')->unique();
            $table->string('vehicle_type');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'out_of_service'])->default('available');
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambulances');
    }
};
