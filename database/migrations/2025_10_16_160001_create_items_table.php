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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_id')->unique();
            $table->string('item_name');
            $table->string('category');
            $table->integer('quantity');
            $table->string('unit');
            $table->integer('reorder_level');
            $table->decimal('price_per_unit', 10, 2);
            $table->unsignedBigInteger('supplier_id');
            $table->enum('status', ['Available', 'Out of Stock', 'Discontinued'])->default('Available');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
