<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes (Auth)
$routes->group('auth', static function ($routes) {
    $routes->get('login', 'Auth\AuthController::login');
    $routes->post('login', 'Auth\AuthController::loginProcess');
    $routes->get('register', 'Auth\AuthController::register');
    $routes->post('register', 'Auth\AuthController::registerProcess');
    $routes->get('logout', 'Auth\AuthController::logout');
    $routes->get('forgot-password', 'Auth\AuthController::forgotPassword');
    $routes->post('forgot-password', 'Auth\AuthController::processForgotPassword');
});

// Member routes (Protected)
$routes->group('member', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Member\DashboardController::index');
    
    // Books routes
    $routes->group('books', static function ($routes) {
        $routes->get('search', 'Member\BookController::search');
        $routes->get('(:num)', 'Member\BookController::detail/$1');
        $routes->get('recommendations', 'Member\BookController::recommendations');
    });
    
    // Borrowing routes
    $routes->group('borrowings', static function ($routes) {
        $routes->get('/', 'Member\BorrowingController::index');
        $routes->get('(:num)', 'Member\BorrowingController::detail/$1');
        $routes->post('borrow', 'Member\BorrowingController::borrow');
        $routes->post('return', 'Member\BorrowingController::return');
        $routes->get('return', 'Member\BorrowingController::returnForm');
    });
    
    // Profile routes
    $routes->get('profile', 'Member\ProfileController::index');
    $routes->put('profile', 'Member\ProfileController::update');
    $routes->get('settings', 'Member\ProfileController::settings');
    $routes->put('settings', 'Member\ProfileController::updateSettings');
});

// Librarian routes (Protected)
$routes->group('librarian', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Librarian\DashboardController::index');
    
    // Member management
    $routes->group('members', static function ($routes) {
        $routes->get('/', 'Librarian\MemberController::index');
        $routes->get('create', 'Librarian\MemberController::create');
        $routes->post('store', 'Librarian\MemberController::store');
        $routes->get('(:num)', 'Librarian\MemberController::show/$1');
        $routes->get('(:num)/edit', 'Librarian\MemberController::edit/$1');
        $routes->put('(:num)', 'Librarian\MemberController::update/$1');
        $routes->delete('(:num)', 'Librarian\MemberController::delete/$1');
    });
    
    // Book management
    $routes->group('books', static function ($routes) {
        $routes->get('/', 'Librarian\BookController::index');
        $routes->get('create', 'Librarian\BookController::create');
        $routes->post('store', 'Librarian\BookController::store');
        $routes->get('(:num)', 'Librarian\BookController::show/$1');
        $routes->get('(:num)/edit', 'Librarian\BookController::edit/$1');
        $routes->put('(:num)', 'Librarian\BookController::update/$1');
        $routes->delete('(:num)', 'Librarian\BookController::delete/$1');
    });
    
    // Transaction management
    $routes->group('transactions', static function ($routes) {
        $routes->get('/', 'Librarian\TransactionController::index');
        $routes->get('(:num)', 'Librarian\TransactionController::show/$1');
        $routes->post('approve-return', 'Librarian\TransactionController::approveReturn');
    });
    
    // Reports
    $routes->get('reports', 'Librarian\ReportController::index');
});

// Fallback route
$routes->get('/', 'Home::index');
