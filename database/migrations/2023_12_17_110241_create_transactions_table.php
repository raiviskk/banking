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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('account_id')->constrained();
            $table->string('type'); // e.g., deposit, withdrawal, transfer, investment, etc.
            $table->integer('amount'); // Represented in the smallest unit of currency (e.g., cents)
            $table->string('direction'); // 'in' or 'out'
            $table->timestamp('timestamp');

            // Additional transaction-related fields
            $table->text('description')->nullable(); // Description or notes about the transaction
            $table->text('reference_id')->nullable(); // Reference to another transaction or document
            // Add more fields as needed

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
