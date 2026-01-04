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
        $result= app(BookServices::class)
            ->createBook($args['input']);

        return [
            'message' => 'berhasil disimpan',
            'data' => $result
        ];
    }

    public function update($_, array $args)
    {
        $result=app(BookServices::class)
            ->updateBook($args['id'], $args['input']);
        return [
            'message' => 'berhasil diupdate',
            'data' => $result
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
