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
        Schema::create('medicines', function (Blueprint $table) {
$table->id();
$table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();


$table->string('medicine_name');
$table->string('brand')->nullable();
$table->string('category')->nullable();
$table->string('batch_no')->nullable();
$table->date('expiry_date')->nullable();
$table->string('image')->nullable();


$table->integer('stock')->default(0);
$table->decimal('purchase_price', 10, 2)->default(0);
$table->decimal('sale_price', 10, 2)->default(0);


$table->boolean('status')->default(1);
$table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
