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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools')->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'borrowed', 'returned', 'cancelled'])->default('pending');
            $table->dateTime('borrow_date');
            $table->dateTime('return_date');
            $table->unsignedBigInteger('damage_report_id')->nullable()->constrained('damage_reports')->onDelete('set null');
            $table->boolean('is_paid')->default(false);
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->enum('deposit_status', ['paid', 'returned', 'deducted',  'pending'])->default('paid');
            // $table->string('payment_status')->nullable()->default('pending'); //pending, comfirmed, awaiting_comfirmation, delivered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
