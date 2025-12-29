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
        Schema::create('doctor_charges', function (Blueprint $table) {
            $table->id();

            // Doctor (Employee) relation
            $table->unsignedBigInteger('employee_id')->nullable();

            $table->string('name')->nullable();
            // Main charge amount
            $table->decimal('charge', 10, 2);

            // Type: test / appointment / consultation
            $table->enum('type', ['test', 'appointment', 'consultation'])->nullable();

            // Sub type: video / voice / chat / online / offline etc
            $table->string('sub_type')->nullable();

            // Optional description
            $table->text('description')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_charges');
    }
};
