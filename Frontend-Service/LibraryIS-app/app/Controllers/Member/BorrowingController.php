<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class BorrowingController extends BaseController
{
    public function index()
    {
        // TODO: Fetch borrowing list from backend API
        $data = [
            'borrowings' => [],
            'page' => $this->request->getGet('page', 1),
            'perPage' => 10,
            'totalResults' => 0,
        ];

        return view('member/borrowings/index', $data);
    }

    public function detail($borrowingId)
    {
        // TODO: Fetch borrowing details from backend API
        $data = [
            'borrowingId' => $borrowingId,
            'borrowing' => [],
        ];

        return view('member/borrowings/index', $data);
    }

    public function borrow()
    {
        $bookId = $this->request->getPost('book_id');

        // TODO: Call backend API to create borrowing
        // POST /api/borrowings with book_id

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book borrowed successfully',
        ]);
    }

    public function returnForm()
    {
        // TODO: Fetch borrowings ready to return
        $data = [
            'borrowings' => [],
        ];

        return view('member/borrowings/index', $data);
    }

    public function return()
    {
        $borrowingId = $this->request->getPost('borrowing_id');

        // TODO: Call backend API to return book
        // POST /api/borrowings/{id}/return

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book returned successfully',
        ]);
    }
}
