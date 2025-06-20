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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rentel_id')->constrained('rentals')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['deposit', 'rental', 'compensation'])->default('deposit');
            $table->enum('status', ['paid', 'refunded', 'failed'])->default('paid');
            $table->string('payment_gateway_id')->nullable();
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
