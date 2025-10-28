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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_id', 50)->unique();
            $table->string('room_no', 50);
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('profession_id')->references('id')->on('professions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
