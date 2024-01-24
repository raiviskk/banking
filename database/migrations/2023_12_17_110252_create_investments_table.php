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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('amount_invested'); // Represented in the smallest unit of currency (e.g., cents)
            $table->string('investment_type')->default('stock'); // Default investment type
            $table->integer('returns')->nullable(); // Represented in the smallest unit of currency (e.g., cents)
            $table->integer('price_at_investment'); // Represented in the smallest unit of currency (e.g., cents)

            // Additional investment-related fields
            $table->text('description')->nullable(); // Description or notes about the investment
            $table->integer('reference_id')->nullable(); // Reference to another investment or document
            // Add more fields as needed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
