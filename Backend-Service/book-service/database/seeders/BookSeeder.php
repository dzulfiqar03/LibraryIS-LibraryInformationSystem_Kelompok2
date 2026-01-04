<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function Symfony\Component\Clock\now;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://gutendex.com/books/');
        $books = $response->json('results');
        foreach ($books as $key => $book) {
            DB::table('books')->insert(
                [
                    'title' => $book['title'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]
            );
        }
    }
}
