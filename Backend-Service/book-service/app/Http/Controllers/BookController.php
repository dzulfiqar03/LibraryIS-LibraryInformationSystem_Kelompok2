<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Services\BookServices;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected BookServices $bookService
    ) {}
    public function index()
    {
        $book = Book::with('book_detail')->latest()->get();
        return response()->json(
            [
                'message' => 'berhasil',
                'data' => $book
            ],
            200
        )->pretty();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $book = $this->bookService->createBook($request->validated());

        return response()->json(
            [
                'message' => 'berhasil',
                'data' => $book
            ],
            200
        )->pretty();
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json(
            [
                'message' => 'berhasil',
                'data' => $book->load('book_detail')
            ],
            200
        )->pretty();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $book = $this->bookService->updateBook($book->id, $request->validated());

        return response()->json(
            [
                'message' => 'berhasil diupdate',
                'data' => $book
            ],
            200
        )->pretty();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book = $this->bookService->deleteBook($book->id);

        return response()->json(
            [
                'message' => 'berhasil dihapus',
                'data' => $book
            ],
            200
        )->pretty();
    }
}
