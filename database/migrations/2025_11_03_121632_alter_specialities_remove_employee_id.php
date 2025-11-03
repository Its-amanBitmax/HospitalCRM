<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('specialities', function (Blueprint $table) {
            // employee_id को nullable बनाएं या हटाएँ
            $table->dropColumn('employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('specialities', function (Blueprint $table) {
            $table->foreignId('employee_id')->after('image')->nullable()->constrained();
        });
    }
};