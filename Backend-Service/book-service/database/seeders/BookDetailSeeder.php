<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BookDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://gutendex.com/books/');
        $books = $response->json('results');

        foreach ($books as $key => $book) {

            DB::table('book_details')->insert(
                [
                    'id_book' => $key + 1,
                    'authors' => $book['authors'][0]['name'] ?? 'Unknown',
                    'languages' => $book['languages'][0],
                    'url_cover' => $book['formats']['application/epub+zip'],
                    'url_ebook' => $book['formats']['image/jpeg'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
