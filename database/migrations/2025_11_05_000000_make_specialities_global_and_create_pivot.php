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
        // Create the pivot table first
        Schema::create('employee_speciality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
            $table->enum('proficiency_level', ['Beginner', 'Intermediate', 'Advanced', 'Expert'])->default('Beginner');
            $table->integer('years_of_experience')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Copy data to pivot table
        DB::statement('INSERT INTO employee_speciality (employee_id, speciality_id, proficiency_level, years_of_experience, image, created_at, updated_at) SELECT employee_id, id, proficiency_level, years_of_experience, image, created_at, updated_at FROM specialities WHERE employee_id IS NOT NULL');

        // Modify the specialities table
        Schema::table('specialities', function (Blueprint $table) {
            DB::statement('ALTER TABLE specialities DROP FOREIGN KEY expertise_employee_id_foreign');
            $table->dropColumn(['employee_id', 'proficiency_level', 'years_of_experience']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_speciality');

        Schema::table('specialities', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->enum('proficiency_level', ['Beginner', 'Intermediate', 'Advanced', 'Expert']);
            $table->integer('years_of_experience')->nullable();
        });
    }
};
