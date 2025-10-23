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
        Schema::table('payroll', function (Blueprint $table) {
            $table->string('bank_name', 100)->nullable()->after('bank_account');
            $table->string('ifsc_code', 20)->nullable()->after('bank_name');
            $table->string('upi_number', 50)->nullable()->after('ifsc_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'ifsc_code', 'upi_number']);
        });
    }
};
