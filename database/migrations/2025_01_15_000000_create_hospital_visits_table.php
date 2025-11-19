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
        Schema::create('hospital_visits', function (Blueprint $table) {
            $table->id();

            /* Visitor / Attender Info */
            $table->string('visitor_name')->nullable();
            $table->string('visitor_contact')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('visitor_relation')->nullable(); // Patient se relation: Father, Wife, Brother

            /* Visit Type - Hospital Specific */
            $table->enum('visit_type', [
                'patient_visit',     // Ward / ICU visitor
                'doctor_meeting',    // Doctor appointment
                'staff_meeting',     // Management related
                'delivery',          // Medicine/Equipment Deliveries
                'emergency',         // Emergency walk-in
                'invite',            // Hospital guest / event
                'vendor'             // Vendor visit
            ])->default('patient_visit');

            /* Purpose / Reason */
            $table->string('purpose')->nullable();
            $table->text('notes')->nullable();

            /* Patient Link (if visiting patient) */
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('patient_mr_no')->nullable(); // Medical Record Number

            /* Doctor Link (if meeting doctor) */
            $table->unsignedBigInteger('doctor_id')->nullable();

            /* Invitation Module */
            $table->dateTime('invited_at')->nullable(); // जब invite भेजा गया
            $table->enum('invite_status', [
                'none',       // normal visit
                'pending',    // invite sent
                'accepted',
                'declined'
            ])->default('none');

            /* Visit Time */
            $table->dateTime('scheduled_visit')->nullable(); // appointment or planned time
            $table->dateTime('check_in')->nullable();        // hospital entry
            $table->dateTime('check_out')->nullable();       // hospital exit

            /* Status (Hospital Logic) */
            $table->enum('status', [
                'invited',      // invited guest
                'scheduled',    // expected visit
                'waiting',      // waiting in hospital
                'in_progress',  // currently inside ward/meeting
                'completed',    // visit done
                'cancelled'
            ])->default('scheduled');

            /* Security & Compliance */
            $table->string('id_proof_type')->nullable(); // Aadhar/PAN/Driving License
            $table->string('id_proof_number')->nullable();
            $table->string('badge_number')->nullable(); // hospital entry pass

            /* Admin Tracking */
            $table->unsignedBigInteger('created_by')->nullable(); // receptionist/staff
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_visits');
    }
};
