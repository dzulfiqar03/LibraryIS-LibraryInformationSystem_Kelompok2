<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\BookService;

class BookController extends BaseController
{
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    /**
     * List all books
     */
    public function index()
    {
        try {
            $books = $this->bookService->getAllBooks();
            
            return view('admin/books/index', [
                'books' => $books,
                'user'  => session()->get('user')
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Failed to load books: ' . $e->getMessage());
            return redirect()->to('admin/dashboard');
        }
    }

    /**
     * Show create book form
     */
    public function create()
    {
        return view('admin/books/create', [
            'user' => session()->get('user')
        ]);
    }

    /**
     * Store a new book
     */
    public function store()
    {
        try {
            $data = [
                'title'            => $this->request->getPost('title'),
                'author'           => $this->request->getPost('author'),
                'isbn'             => $this->request->getPost('isbn'),
                'publisher'        => $this->request->getPost('publisher'),
                'publication_year' => $this->request->getPost('publication_year'),
                'category'         => $this->request->getPost('category'),
                'description'      => $this->request->getPost('description'),
                'pages'            => $this->request->getPost('pages'),
                'language'         => $this->request->getPost('language'),
                'quantity'         => $this->request->getPost('quantity'),
            ];

            $response = $this->bookService->createBook($data);

            if ($response) {
                session()->setFlashdata('success', 'Book added successfully');
                return redirect()->to('admin/books');
            } else {
                session()->setFlashdata('error', 'Failed to add book');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show book details
     */
    public function show($bookId)
    {
        try {
            $book = $this->bookService->getBookById($bookId);

            if (!$book) {
                throw new \Exception('Book not found');
            }

            return view('admin/books/detail', [
                'book' => $book,
                'user' => session()->get('user')
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('admin/books');
        }
    }

    /**
     * Show edit book form
     */
    public function edit($bookId)
    {
        try {
            $book = $this->bookService->getBookById($bookId);

            if (!$book) {
                throw new \Exception('Book not found');
            }

            return view('admin/books/edit', [
                'book' => $book,
                'user' => session()->get('user')
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('admin/books');
        }
    }

    /**
     * Update book details
     */
    public function update($bookId)
    {
        try {
            $data = [
                'title'            => $this->request->getPost('title'),
                'author'           => $this->request->getPost('author'),
                'isbn'             => $this->request->getPost('isbn'),
                'publisher'        => $this->request->getPost('publisher'),
                'publication_year' => $this->request->getPost('publication_year'),
                'category'         => $this->request->getPost('category'),
                'description'      => $this->request->getPost('description'),
                'pages'            => $this->request->getPost('pages'),
                'language'         => $this->request->getPost('language'),
                'quantity'         => $this->request->getPost('quantity'),
            ];

            $response = $this->bookService->updateBook($bookId, $data);

            if ($response) {
                session()->setFlashdata('success', 'Book updated successfully');
                return redirect()->to('admin/books/' . $bookId);
            } else {
                session()->setFlashdata('error', 'Failed to update book');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Delete a book
     */
    public function delete($bookId)
    {
        try {
            if ($this->request->getMethod() === 'post') {
                $response = $this->bookService->deleteBook($bookId);

                if ($response) {
                    session()->setFlashdata('success', 'Book deleted successfully');
                    return redirect()->to('admin/books');
                } else {
                    session()->setFlashdata('error', 'Failed to delete book');
                    return redirect()->to('admin/books/' . $bookId);
                }
            }

            // GET request → show confirmation page
            return view('admin/books/delete-confirm', [
                'book' => $this->bookService->getBookById($bookId),
                'user' => session()->get('user')
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('admin/books');
        }
    }
}