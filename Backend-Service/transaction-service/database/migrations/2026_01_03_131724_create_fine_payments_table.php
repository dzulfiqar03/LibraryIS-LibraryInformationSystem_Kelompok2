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
        Schema::create('fine_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_transaction');
            $table->string('id_member');
            $table->decimal('fine_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('description')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->string('payment_method')->nullable(); // 'cash', 'transfer', etc.
            $table->timestamps();

            $table->foreign('id_transaction')->references('id')->on('transactions')->onDelete('cascade');
            $table->index(['id_member', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fine_payments');
    }
};
