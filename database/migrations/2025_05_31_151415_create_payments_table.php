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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //المستاجر
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete(); // الادة
            $table->foreignId('rental_id')->constrained()->cascadeOnDelete(); // طلب الإجارة
            $table->decimal('amount', 10, 2); // (deposit amount) total
            $table->decimal('deposit_amount', 10,2)->nullable();
            $table->decimal('rental_amount', 10,2)->nullable();
            $table->decimal('processing_fee', 10,2)->nullable(); // paystack (1.5 + 150, 1%)
            $table->string('payment_type');  // deposit or full
            $table->string('status');  // pending, awaiting_comfirmation, confirmed, failed, delivered,
            $table->string('transaction_id')->nullable();  // Paystack id or يدوي
            $table->string('payment_method')->nullable();  // card, ussd, mobile_money, bank_transfer
            $table->string('proof_of_payment')->nullable(); // رابط إثبات الدفع
            $table->string('delivery_code'); // كود التسلبم (6 ارقام)
            $table->boolean('is_delivered')->default(false);  //حالة التسليم
            $table->string('refund_status');  //pending, completed, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
