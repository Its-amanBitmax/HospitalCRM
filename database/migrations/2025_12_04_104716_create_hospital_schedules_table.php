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
         Schema::create('hospital_schedules', function (Blueprint $table) {
            $table->id();

            // Hospital date range
            $table->date('start_date'); 
            $table->date('end_date');   

            // Hospital working hours (AM/PM allowed while inserting)
            $table->string('start_time');  
            $table->string('end_time');    

            // Status (active/inactive)
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_schedules');
    }
};
