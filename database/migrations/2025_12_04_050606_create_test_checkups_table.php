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
        Schema::create('test_checkups', function (Blueprint $table) {
            $table->id();

            $table->string('test_name');
            $table->string('test_code')->nullable();
            $table->string('category')->nullable();

            // Department Foreign Key
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            // Sample
            $table->boolean('sample_required')->default(false);
            $table->string('sample_type')->nullable();

            // Fasting
            $table->boolean('fasting_required')->default(false);

            // Report
            $table->string('unit')->nullable();
            $table->json('normal_range')->nullable();
            $table->text('instructions')->nullable();
            $table->string('tat')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_checkups');
    }
};
