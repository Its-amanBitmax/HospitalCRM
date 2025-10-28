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
        Schema::create('room_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('profession_id')->references('id')->on('professions');
            $table->foreign('assigned_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_assignments');
    }
};
