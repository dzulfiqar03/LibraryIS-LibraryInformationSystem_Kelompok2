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
        Schema::create('book_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_book')->constrained('books')->onDelete('cascade');
            $table->string('authors')->nullable();
            $table->string('languages')->nullable();
            $table->string('url_cover')->nullable();
            $table->string('url_ebook')->nullable();
            $table->enum('status', ['active', 'non active']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_details');
    }
};
