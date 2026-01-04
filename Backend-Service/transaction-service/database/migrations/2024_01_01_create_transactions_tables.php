<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_member');
            $table->dateTime('transaction_date')->default(Date::now());
            $table->dateTime('due_date')->default(Date::now()->addDays(14));
            $table->dateTime('return_date')->nullable();
            $table->enum('status', ['available','borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->decimal('fine_amount', 10, 2)->default(0);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
