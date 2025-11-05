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
        Schema::create('relatives', function (Blueprint $table) {
            $table->id('relative_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 100);
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('relation', 50)->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatives');
    }
};
