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
        Schema::table('patient_visits', function (Blueprint $table) {
               $table->unsignedBigInteger('department_consultant')->nullable()->change();

    // Then add FK
    $table->foreign('department_consultant')
        ->references('id')
        ->on('room_assignments')
        ->onDelete('set null')
        ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_visits', function (Blueprint $table) {
            //
        });
    }
};
