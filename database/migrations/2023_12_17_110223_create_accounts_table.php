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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->foreignId('user_id')->constrained();
            $table->string('account_type');
            $table->foreign('account_type')->references('type')->on('account_types');
            $table->unsignedBigInteger('balance')->default(0);
            $table->string('currency_code');
            $table->foreign('currency_code')->references('code')->on('currencies');
            $table->timestamps();
            $table->date('opened_at');
            $table->date('closed_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
