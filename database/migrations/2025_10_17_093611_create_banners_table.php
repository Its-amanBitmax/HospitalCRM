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
        Schema::create('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('banner_id')->autoIncrement()->primary(); // Primary key auto increment
            $table->string('title', 150);
            $table->string('image_url', 255);
            $table->string('redirect_url', 255);
            $table->enum('position', ['Top', 'Sidebar', 'Bottom', 'HomePage']);
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
