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
        // Create patient_visits table
        Schema::create('patient_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('visit_type', ['OPD', 'Emergency', 'Appointment']);
            $table->date('date_of_visit');
            $table->text('chief_complaint')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('department_consultant')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'date_of_visit']);
        });

        // Create patient_checkups table
        Schema::create('patient_checkups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('checkup_date');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'checkup_date']);
        });

        // Create patient_documents table
        Schema::create('patient_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('document_type');
            $table->string('document_path');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'document_type']);
        });

        // Remove visit-related columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_visit_date');
            $table->dropColumn(['visit_type', 'date_of_visit', 'chief_complaint', 'referred_by', 'department_consultant']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('visit_type', ['OPD', 'Emergency', 'Appointment'])->nullable();
            $table->date('date_of_visit')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('department_consultant')->nullable();
            $table->index('date_of_visit', 'idx_visit_date');
        });

        // Drop the new tables
        Schema::dropIfExists('patient_documents');
        Schema::dropIfExists('patient_checkups');
        Schema::dropIfExists('patient_visits');
    }
};
