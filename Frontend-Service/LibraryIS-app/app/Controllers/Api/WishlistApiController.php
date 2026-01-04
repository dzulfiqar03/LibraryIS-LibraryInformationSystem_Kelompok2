<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

class WishlistApiController extends \CodeIgniter\Controller
{
    use ResponseTrait;

    /**
     * Toggle book in wishlist
     */
    public function toggle()
    {
        try {
            $input = $this->request->getJSON();
            
            // Get current user from session
            $user = session('user');
            if (!$user) {
                return $this->failUnauthorized('User not authenticated');
            }

            $bookId = $input->book_id ?? null;
            if (!$bookId) {
                return $this->fail([
                    'success' => false,
                    'message' => 'Book ID is required'
                ], 400);
            }

            // Get or initialize wishlist from session
            $wishlist = session('wishlist') ?? [];
            
            // Toggle book in wishlist
            if (in_array($bookId, $wishlist)) {
                $wishlist = array_filter($wishlist, function($id) use ($bookId) {
                    return $id != $bookId;
                });
                $added = false;
            } else {
                $wishlist[] = $bookId;
                $added = true;
            }

            // Save to session
            session()->set('wishlist', array_values($wishlist));

            return $this->respond([
                'success' => true,
                'message' => $added ? 'Added to wishlist' : 'Removed from wishlist',
                'added' => $added,
                'wishlist' => session('wishlist')
            ]);
        } catch (\Exception $e) {
            return $this->fail([
                'success' => false,
                'message' => 'Error updating wishlist: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user's wishlist
     */
    public function index()
    {
        try {
            $user = session('user');
            if (!$user) {
                return $this->failUnauthorized('User not authenticated');
            }

            $wishlist = session('wishlist') ?? [];

            return $this->respond([
                'success' => true,
                'wishlist' => $wishlist
            ]);
        } catch (\Exception $e) {
            return $this->fail([
                'success' => false,
                'message' => 'Error fetching wishlist: ' . $e->getMessage()
            ]);
        }
    }
}
