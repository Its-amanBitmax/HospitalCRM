<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blood_banks', function (Blueprint $table) {
            $table->id();

            // Blood details
            $table->string('blood_group', 5);
            $table->unsignedInteger('units');

            // Donor details
            $table->string('donor_name');
            $table->string('donor_contact', 20);
            $table->text('donor_address')->nullable();

            // Status
            $table->enum('status', ['available', 'low', 'out_of_stock'])
                ->default('available');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_banks');
    }
};

