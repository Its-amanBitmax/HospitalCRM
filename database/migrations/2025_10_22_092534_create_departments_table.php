<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (bigint unsigned)
            $table->string('department_id', 50)->unique(); // Unique department ID as string
            $table->string('department_name', 150);
            $table->string('department_code', 50);
            $table->string('image_url', 255)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->primary('id'); // Ensure id is the primary key
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}