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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('check_in_ip')->nullable()->after('check_in');
            $table->text('check_in_location')->nullable()->after('check_in_ip');
            $table->string('check_out_ip')->nullable()->after('check_out');
            $table->text('check_out_location')->nullable()->after('check_out_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
};
