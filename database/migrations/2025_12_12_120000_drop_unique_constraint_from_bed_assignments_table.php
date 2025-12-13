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
        // Use raw SQL to drop the constraint and recreate foreign keys
        DB::statement('ALTER TABLE bed_assignments DROP FOREIGN KEY bed_assignments_user_id_foreign');
        DB::statement('ALTER TABLE bed_assignments DROP FOREIGN KEY bed_assignments_bed_id_foreign');
        DB::statement('ALTER TABLE bed_assignments DROP INDEX unique_active_bed_assignment');
        DB::statement('ALTER TABLE bed_assignments ADD CONSTRAINT bed_assignments_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE bed_assignments ADD CONSTRAINT bed_assignments_bed_id_foreign FOREIGN KEY (bed_id) REFERENCES beds(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bed_assignments', function (Blueprint $table) {
            $table->unique(['user_id', 'bed_id', 'status'], 'unique_active_bed_assignment');
        });
    }
};
