<?php

namespace App\Services;

/**
 * GraphQL Queries and Mutations for Library Service
 * 
 * This class contains all GraphQL queries and mutations used by the frontend
 * to communicate with the backend GraphQL services.
 */
class GraphQLQueries
{
    // ============================================
    // MEMBER SERVICE MUTATIONS (Port 8001)
    // ============================================

    /**
     * User login mutation
     * Used with Member Service
     */
    public static function login(): string
    {
        return <<<'GraphQL'
            mutation Login($email: String!, $password: String!) {
                login(email: $email, password: $password) {
                    success
                    message
                    token
                    user {
                        id
                        name
                        email
                        phone
                        address
                        createdAt
                    }
                }
            }
        GraphQL;
    }

    /**
     * User registration mutation
     * Used with Member Service
     */
    public static function register(): string
    {
        return <<<'GraphQL'
            mutation Register($name: String!, $email: String!, $password: String!, $phone: String, $address: String) {
                register(
                    name: $name
                    email: $email
                    password: $password
                    phone: $phone
                    address: $address
                ) {
                    success
                    message
                    token
                    user {
                        id
                        name
                        email
                        phone
                        address
                        createdAt
                    }
                }
            }
        GraphQL;
    }

    /**
     * Request password reset mutation
     * Used with Member Service
     */
    public static function requestPasswordReset(): string
    {
        return <<<'GraphQL'
            mutation RequestPasswordReset($email: String!) {
                requestPasswordReset(email: $email) {
                    success
                    message
                }
            }
        GraphQL;
    }

    /**
     * Reset password mutation
     * Used with Member Service
     */
    public static function resetPassword(): string
    {
        return <<<'GraphQL'
            mutation ResetPassword($token: String!, $password: String!) {
                resetPassword(token: $token, password: $password) {
                    success
                    message
                }
            }
        GraphQL;
    }

    // ============================================
    // GRAPHQL INTEGRATION SERVICE QUERIES (Port 8000)
    // ============================================

    /**
     * Get current user profile query
     * Requires JWT token
     */
    public static function getCurrentUser(): string
    {
        return <<<'GraphQL'
            query GetMe {
                me {
                    id
                    name
                    email
                    phone
                    address
                    createdAt
                    updatedAt
                }
            }
        GraphQL;
    }

    /**
     * Update user profile mutation
     * Requires JWT token
     */
    public static function updateProfile(): string
    {
        return <<<'GraphQL'
            mutation UpdateProfile($name: String, $phone: String, $address: String) {
                updateProfile(name: $name, phone: $phone, address: $address) {
                    success
                    message
                    user {
                        id
                        name
                        email
                        phone
                        address
                    }
                }
            }
        GraphQL;
    }

    /**
     * Change password mutation
     * Requires JWT token
     */
    public static function changePassword(): string
    {
        return <<<'GraphQL'
            mutation ChangePassword($currentPassword: String!, $newPassword: String!) {
                changePassword(currentPassword: $currentPassword, newPassword: $newPassword) {
                    success
                    message
                }
            }
        GraphQL;
    }

    // ============================================
    // BOOK SERVICE QUERIES (Port 8002)
    // ============================================

    /**
     * Get all books
     * Queries Book Service at http://127.0.0.1:8002/api/graphql
     */
    public static function getAllBooks(): string
    {
        return <<<'GraphQL'
            query GetAllBooks {
                books {
                    booksList {
                        id
                        title
                        book_detail {
                            authors
                            languages
                            url_cover
                            url_ebook
                            status
                        }
                    }
                }
            }
        GraphQL;
    }

    /**
     * Get all books (legacy name)
     */
    public static function getBooks(): string
    {
        return self::getAllBooks();
    }

    /**
     * Get book detail by ID
     * Queries Book Service at http://127.0.0.1:8002/api/graphql
     */
    public static function getBookDetail(): string
    {
        return <<<'GraphQL'
            query GetBook($id: ID!) {
                book(id: $id) {
                    id
                    title
                    book_detail {
                        authors
                        languages
                        url_cover
                        url_ebook
                        status
                    }
                }
            }
        GraphQL;
    }

    /**
     * Search books
     * Queries Book Service at http://127.0.0.1:8002/api/graphql
     */
    public static function searchBooks(): string
    {
        return <<<'GraphQL'
            query SearchBooks($search: String!) {
                books {
                    booksList {
                        id
                        title
                        book_detail {
                            authors
                            languages
                            url_cover
                            url_ebook
                            status
                        }
                    }
                }
            }
        GraphQL;
    }

    /**
     * Get book recommendations
     * Queries Book Service at http://127.0.0.1:8002/api/graphql
     */
    public static function getRecommendations(): string
    {
        return <<<'GraphQL'
            query GetRecommendations {
                books {
                    booksList {
                        id
                        title
                        book_detail {
                            authors
                            url_cover
                        }
                    }
                }
            }
        GraphQL;
    }

    // ============================================
    // TRANSACTION SERVICE QUERIES (Port 8003)
    // ============================================

    /**
     * Get user borrowing/transaction history
     * Requires JWT token
     * Queries Transaction Service at http://127.0.0.1:8003/api/graphql
     */
    public static function getBorrowings(): string
    {
        return <<<'GraphQL'
            query GetTransactions {
                transactions {
                    transactionList {
                        id
                        id_member
                        status
                        transaction_details {
                            id
                            id_transaction
                            id_book
                            quantity
                            price
                        }
                    }
                }
            }
        GraphQL;
    }

    /**
     * Get borrowing detail by ID
     * Requires JWT token
     * Queries Transaction Service at http://127.0.0.1:8003/api/graphql
     */
    public static function getBorrowingDetail(): string
    {
        return <<<'GraphQL'
            query GetTransaction($id: ID!) {
                transaction(id: $id) {
                    id
                    id_member
                    status
                    transaction_details {
                        id
                        id_transaction
                        id_book
                        quantity
                        price
                    }
                }
            }
        GraphQL;
    }

    /**
     * Create transaction (borrow books)
     * Requires JWT token
     * Queries Transaction Service at http://127.0.0.1:8003/api/graphql
     */
    public static function borrowBook(): string
    {
        return <<<'GraphQL'
            mutation CreateTransaction($input: CreateTransactionInput!) {
                createTransaction(input: $input) {
                    message
                    data {
                        id
                        id_member
                        status
                        transaction_details {
                            id_book
                            quantity
                            price
                        }
                    }
                }
            }
        GraphQL;
    }

    /**
     * Return borrowed book (update transaction)
     * Requires JWT token
     * Queries Transaction Service at http://127.0.0.1:8003/api/graphql
     */
    public static function returnBook(): string
    {
        return <<<'GraphQL'
            mutation UpdateTransaction($id: ID!, $input: CreateTransactionInput!) {
                updateTransaction(id: $id, input: $input) {
                    message
                    data {
                        id
                        status
                    }
                }
            }
        GraphQL;
    }

    /**
     * Get active borrowings (currently borrowed books)
     * Requires JWT token
     * Queries Transaction Service at http://127.0.0.1:8003/api/graphql
     */
    public static function getActiveBorrowings(): string
    {
        return <<<'GraphQL'
            query GetTransactions {
                transactions {
                    transactionList {
                        id
                        id_member
                        status
                        transaction_details {
                            id_book
                            quantity
                        }
                    }
                }
            }
        GraphQL;
    }

    /**
     * Check if book is available for borrowing
     * Queries Book Service at http://127.0.0.1:8002/api/graphql
     */
    public static function checkBookAvailability(): string
    {
        return <<<'GraphQL'
            query GetBook($id: ID!) {
                book(id: $id) {
                    id
                    title
                    book_detail {
                        status
                    }
                }
            }
        GraphQL;
    }
}
