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
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->string('bed_id')->unique();
            $table->unsignedBigInteger('ward_id');
            $table->enum('type', ['General', 'Critical', 'Deluxe'])->default('General');
            $table->enum('status', ['Active', 'Occupied', 'Maintenance'])->default('Active');
            $table->timestamps();

            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
