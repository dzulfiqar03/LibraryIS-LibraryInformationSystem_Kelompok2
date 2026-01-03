<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not change the request or response.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user has JWT token in session
        if (!session()->has('jwt_token') || !session()->has('user')) {
            // Check if this is an API request
            $uri = $request->getUri()->getPath();
            if (strpos($uri, '/api/') !== false || $request->hasHeader('X-Requested-With')) {
                // Return JSON error response for API requests
                return response()->setJSON([
                    'success' => false,
                    'message' => 'Authentication required. Please log in to access this endpoint.',
                    'code' => 401
                ])->setStatusCode(401);
            }
            
            // Redirect to login page for regular requests
            return redirect()->to('/auth/login')->with('error', 'You must be logged in to access this page');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not need to return anything.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
