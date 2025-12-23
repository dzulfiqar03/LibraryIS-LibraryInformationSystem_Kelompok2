<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class BookController extends BaseController
{
    public function search()
    {
        // TODO: Fetch search results from backend API based on query parameters
        $searchQuery = $this->request->getGet('search') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $language = $this->request->getGet('language') ?? '';
        $sortBy = $this->request->getGet('sort') ?? 'relevance';

        $data = [
            'searchQuery' => $searchQuery,
            'category' => $category,
            'language' => $language,
            'sortBy' => $sortBy,
            'results' => [],
            'totalResults' => 0,
            'currentPage' => 1,
            'perPage' => 12,
        ];

        return view('member/books/search', $data);
    }

    public function detail($bookId)
    {
        // TODO: Fetch book details from backend API
        $data = [
            'bookId' => $bookId,
            'book' => [],
            'reviews' => [],
            'relatedBooks' => [],
        ];

        return view('member/books/detail', $data);
    }

    public function recommendations()
    {
        // TODO: Fetch recommendations from backend API
        $data = [
            'recommendations' => [],
            'totalResults' => 0,
        ];

        return view('member/books/recommendations', $data);
    }
}
