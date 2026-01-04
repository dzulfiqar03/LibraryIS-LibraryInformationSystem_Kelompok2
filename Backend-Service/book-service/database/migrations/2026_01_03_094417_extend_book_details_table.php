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
        Schema::table('book_details', function (Blueprint $table) {
            // Add new fields that the frontend expects
            $table->string('isbn')->nullable()->after('authors');
            $table->string('publisher')->nullable()->after('isbn');
            $table->year('publication_year')->nullable()->after('publisher');
            $table->string('category')->default('uncategorized')->after('publication_year');
            $table->text('description')->nullable()->after('category');
            $table->integer('pages')->nullable()->after('description');
            $table->integer('quantity')->default(1)->after('pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_details', function (Blueprint $table) {
            // Remove the added fields
            $table->dropColumn([
                'isbn',
                'publisher',
                'publication_year',
                'category',
                'description',
                'pages',
                'quantity'
            ]);
        });
    }
};
