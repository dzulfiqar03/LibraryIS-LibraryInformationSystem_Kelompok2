<?php

namespace App\GraphQL\Mutations;

use App\Services\BookServices;

class BookMutation
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create($_, array $args)
    {
        app(BookServices::class)
            ->createBook($args['input']);

        return [
            'message' => 'berhasil disimpan',
            'data' => app(BookServices::class)->getAll()
        ];
    }

    public function update($_, array $args)
    {
        app(BookServices::class)
            ->updateBook($args['id'], $args['input']);
        return [
            'message' => 'berhasil diupdate',
            'data' => app(BookServices::class)->getAll()
        ];
    }

    public function delete($_, array $args)
    {
        app(BookServices::class)
            ->deleteBook($args['id']);

        return [
            'message' => 'berhasil dihapus',
            'data' => app(BookServices::class)->getAll()
        ];
    }
}
