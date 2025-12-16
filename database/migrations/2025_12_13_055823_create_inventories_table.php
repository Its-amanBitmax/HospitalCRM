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
        Schema::create('inventories', function (Blueprint $table) {
$table->id();


$table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
$table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();


$table->enum('type', ['IN', 'OUT', 'ADJUST']);
$table->integer('quantity');


$table->integer('stock_before');
$table->integer('stock_after');


$table->string('reference')->nullable(); // Purchase No / Invoice No
$table->text('note')->nullable();


$table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
