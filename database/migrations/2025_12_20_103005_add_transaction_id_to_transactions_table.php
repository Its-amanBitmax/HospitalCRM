<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('id');
        });

        // Generate unique transaction IDs for existing rows
        DB::statement("UPDATE transactions SET transaction_id = CONCAT('TXN-', UPPER(SUBSTRING(MD5(RAND()), 1, 12))) WHERE transaction_id IS NULL");

        // Make the column unique and not null
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_id VARCHAR(255) NOT NULL UNIQUE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
