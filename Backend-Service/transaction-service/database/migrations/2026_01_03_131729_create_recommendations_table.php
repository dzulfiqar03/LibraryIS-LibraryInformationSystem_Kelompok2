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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_member');
            $table->integer('id_book');
            $table->enum('type', ['popular', 'category_based', 'similar_users', 'recently_added'])->default('popular');
            $table->decimal('score', 3, 2)->default(0); // 0.00 to 1.00
            $table->string('reason')->nullable(); // Why this book is recommended
            $table->boolean('is_active')->default(true);
            $table->timestamp('recommended_at');
            $table->timestamps();

            $table->index(['id_member', 'is_active']);
            $table->index(['type', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
