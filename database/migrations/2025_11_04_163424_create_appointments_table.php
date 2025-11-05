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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->string('appointment_code', 20)->unique();
            $table->unsignedBigInteger('booked_by_user_id');
            $table->enum('for_user_type', ['self', 'relative']);
            $table->unsignedBigInteger('relative_id')->nullable();
            $table->unsignedBigInteger('doctor_id');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('issue', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending');
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('booked_by_user_id')->references('id')->on('users');
            $table->foreign('relative_id')->references('relative_id')->on('relatives');
            $table->foreign('doctor_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
