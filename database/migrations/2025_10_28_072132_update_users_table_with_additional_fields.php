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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('father_spouse_name')->nullable();
            $table->string('alternate_no')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code')->nullable();
            $table->enum('visit_type', ['OPD', 'Emergency', 'Appointment'])->nullable();
            $table->date('date_of_visit')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('department_consultant')->nullable();
            $table->string('id_proof_type')->nullable();
            $table->string('id_number')->nullable();
        });

        // Rename columns separately
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('fullname', 'full_name');
            $table->renameColumn('phone_no', 'mobile_no');
            $table->renameColumn('address', 'full_address');
        });

        Schema::table('users', function (Blueprint $table) {
            // Change full_address to TEXT
            $table->text('full_address')->change();

            // Update registered_through enum values
            $table->enum('registered_through', ['email', 'msg', 'whatsapp', 'google'])->nullable()->change();

            // Add indexes
            $table->unique(['user_id', 'email'], 'unique_user_email');
            $table->index('date_of_visit', 'idx_visit_date');
            $table->index('mobile_no', 'idx_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes
            $table->dropUnique('unique_user_email');
            $table->dropIndex('idx_visit_date');
            $table->dropIndex('idx_mobile');

            // Drop new columns
            $table->dropColumn([
                'father_spouse_name',
                'alternate_no',
                'city',
                'state',
                'pin_code',
                'visit_type',
                'date_of_visit',
                'chief_complaint',
                'referred_by',
                'department_consultant',
                'id_proof_type',
                'id_number'
            ]);

            // Revert registered_through enum values
            $table->enum('registered_through', ['email_otp', 'msg', 'whatsapp', 'google'])->nullable()->change();

            // Revert full_address back to string
            $table->string('full_address')->change();

            // Rename columns back
            $table->renameColumn('full_name', 'fullname');
            $table->renameColumn('mobile_no', 'phone_no');
            $table->renameColumn('full_address', 'address');
        });
    }
};
