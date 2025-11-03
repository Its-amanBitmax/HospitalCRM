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
        Schema::rename('expertise', 'specialities');
        Schema::table('specialities', function (Blueprint $table) {
            $table->string('image')->nullable()->after('skill');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specialities', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::rename('specialities', 'expertise');
    }
};
