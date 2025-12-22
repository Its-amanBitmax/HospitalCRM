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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('module', 50);
            $table->decimal('amount', 10, 2);
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->enum('payment_mode', ['cash', 'upi', 'card', 'online',]);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'refunded']);
            $table->date('transaction_date');
            $table->text('remarks')->nullable();
           $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('cascade');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
