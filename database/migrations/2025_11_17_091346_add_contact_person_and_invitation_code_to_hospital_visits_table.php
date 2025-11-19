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
        Schema::table('hospital_visits', function (Blueprint $table) {
            $table->string('contact_person_name')->nullable()->after('visitor_relation');
            $table->string('contact_person_phone')->nullable()->after('contact_person_name');
            $table->string('invitation_code')->unique()->nullable()->after('invite_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospital_visits', function (Blueprint $table) {
            $table->dropColumn(['contact_person_name', 'contact_person_phone', 'invitation_code']);
        });
    }
};
