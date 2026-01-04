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
        Schema::create('member_details', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_user')->constrained('users')->onDelete('cascade');
            $table->unique('id_user');
            $table->enum('membership_status', ['active', 'suspended', 'expired'])->default('active');
            $table->integer('borrowing_count')->default(0);
            $table->decimal('total_fine', 10, 2)->default(0); // Total denda yang belum dibayar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_details');
    }
};
