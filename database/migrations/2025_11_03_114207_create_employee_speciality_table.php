<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_speciality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('speciality_id')->constrained()->onDelete('cascade');

            $table->string('proficiency_level')->nullable();      // Beginner, Intermediate …
            $table->unsignedInteger('years_of_experience')->nullable();

            $table->unique(['employee_id', 'speciality_id']);    // एक employee एक skill एक बार ही
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_speciality');
    }
};