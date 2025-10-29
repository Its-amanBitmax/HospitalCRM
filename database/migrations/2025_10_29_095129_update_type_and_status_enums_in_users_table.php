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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['ipd', 'opd', 'emergency', 'registered', 'discharged'])->default('registered')->change();
            $table->enum('status', ['active', 'inactive', 'discharged'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['ipd', 'opd', 'registered', 'discharged'])->default('registered')->change();
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};
