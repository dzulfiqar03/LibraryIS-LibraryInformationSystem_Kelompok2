<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BookServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Book $book)
    {
        //
    }

    public function getAll()
    {
        return $this->book::with('book_detail')->latest()->get();
    }

    public function getById($id)
    {
        return $this->book::findOrFail($id)->get();
    }
    public function createBook(array $data)
    {
        return DB::transaction(function () use ($data) {

            $book = $this->book->create($data);

            if (request()->is('graphql')) {
                if (!empty($data['detail'])) {
                    $book->book_detail()->create([
                        'authors'   => $data['detail']['authors'] ?? null,
                        'languages' => $data['detail']['languages'] ?? null,
                        'url_cover' => $data['detail']['url_cover'] ?? null,
                        'url_ebook' => $data['detail']['url_ebook'] ?? null,
                        'status'    => $data['detail']['status'] ?? null,
                    ]);
                }
            } else {
                if (
                    isset($data['authors']) ||
                    isset($data['languages']) ||
                    isset($data['status'])
                ) {
                    $book->book_detail()->create([
                        'authors'   => $data['authors'] ?? null,
                        'languages' => $data['languages'] ?? null,
                        'url_cover' => $data['url_cover'] ?? null,
                        'url_ebook' => $data['url_ebook'] ?? null,
                        'status'    => $data['status'] ?? null,
                    ]);
                }
            }


            return $book->load('book_detail');
        });
    }

    public function updateBook($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $book = $this->book->findOrFail($id);
            $book->update($data);

            if (request()->is('graphql')) {
                if (!empty($data['detail'])) {
                    $book->book_detail()->update([
                        'authors'   => $data['detail']['authors'] ?? null,
                        'languages' => $data['detail']['languages'] ?? null,
                        'url_cover' => $data['detail']['url_cover'] ?? null,
                        'url_ebook' => $data['detail']['url_ebook'] ?? null,
                        'status'    => $data['detail']['status'] ?? null,
                    ]);
                }
            } else {
                if (
                    isset($data['authors']) ||
                    isset($data['languages']) ||
                    isset($data['status'])
                ) {
                    $book->book_detail()->update([
                        'authors'   => $data['authors'] ?? null,
                        'languages' => $data['languages'] ?? null,
                        'url_cover' => $data['url_cover'] ?? null,
                        'url_ebook' => $data['url_ebook'] ?? null,
                        'status'    => $data['status'] ?? null,
                    ]);
                }
            }

            return $book->load('book_detail');
        });
    }

    public function deleteBook($id)
    {
        return DB::transaction(function () use ($id) {

            $this->book->where('id', $id)->delete();

            if (
                isset($data['authors']) ||
                isset($data['languages']) ||
                isset($data['status'])
            ) {
                $this->book->book_detail()->where('id_book', $id)->delete();
            }
        });
    }
}
