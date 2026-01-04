# API Integration Guide - LibraryIS Frontend

## Overview

This guide explains how the LibraryIS frontend connects to the backend services using GraphQL and JWT authentication.

## Architecture

### Backend Services

The LibraryIS system consists of multiple backend services:

1. **Member Service** (Port 8001)
   - User authentication and management
   - User registration and login
   - Password reset and profile management
   - GraphQL endpoint: `http://127.0.0.1:8001/api/graphql`

2. **GraphQL Integration Service** (Port 8000)
   - Main API gateway combining all services
   - Book catalog queries
   - Borrowing/transaction management
   - Requires JWT token for authentication
   - GraphQL endpoint: `http://127.0.0.1:8000/api/graphql`

3. **Other Services** (Behind GraphQL Integration)
   - Book Service
   - Transaction Service
   - Additional services

### Authentication Flow

```
┌─────────────┐
│  Frontend   │
└──────┬──────┘
       │
       │ 1. Sign Up / Login
       ▼
┌──────────────────────┐
│ Member Service       │  Returns JWT Token
│ (Port 8001)          │
└──────┬───────────────┘
       │
       │ 2. JWT Token stored in session
       │
       ▼
┌──────────────────────┐
│ GraphQL Integration  │  All authenticated requests
│ Service (Port 8000)  │  with Bearer token
└──────────────────────┘
```

## Getting Started

### 1. Environment Configuration

Update your `.env` file with the backend service URLs:

```env
# GraphQL Integration Service (Main API)
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql

# Member Service (Authentication)
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql

# API timeout in seconds
API_TIMEOUT = 10
```

### 2. Starting Backend Services

**Terminal 1 - GraphQL Integration Service:**
```bash
cd Backend-Service/GraphQL-Integration
php artisan serve --port=8000
```

**Terminal 2 - Member Service:**
```bash
cd Backend-Service/member-service
php artisan serve --port=8001
```

**Terminal 3 - Book Service (If separate):**
```bash
cd Backend-Service/book-service
php artisan serve --port=8002  # or configured port
```

**Terminal 4 - Transaction Service (Queue worker):**
```bash
cd Backend-Service/transaction-service
php artisan queue:work --queue=transaction.book
```

### 3. Starting Frontend

```bash
cd Frontend-Service/LibraryIS-app
php spark serve
```

The frontend will be available at `http://localhost:8080`

## API Integration Details

### ApiClient Service

The `ApiClient` class handles all HTTP requests to the backend services.

**Location:** `app/Services/ApiClient.php`

**Key Methods:**

```php
// Execute GraphQL query against GraphQL Integration Service
$response = $api->graphql($query, $variables);

// Execute GraphQL query against Member Service
$response = $api->memberGraphql($query, $variables);

// Set JWT token for authenticated requests
$api->setToken($token);

// Get current token
$token = $api->getToken();

// Clear token on logout
$api->clearToken();
```

### Authentication Service

Handles all authentication-related operations using the Member Service.

**Location:** `app/Services/AuthService.php`

**Available Methods:**

```php
$auth = new AuthService();

// Login user
$result = $auth->login('user@example.com', 'password');
// Returns: {success: true, message: "...", token: "jwt-token", user: {...}}

// Register new user
$result = $auth->register([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'secure_password',
    'phone' => '08123456789',
    'address' => 'Jl. Example No. 1'
]);
// Returns: {success: true, message: "...", token: "jwt-token", user: {...}}

// Check if authenticated
$isAuth = $auth->isAuthenticated();

// Get current user profile
$user = $auth->getCurrentUser();

// Update profile
$result = $auth->updateProfile(['name' => 'New Name']);

// Change password
$result = $auth->changePassword('old_password', 'new_password');

// Request password reset
$result = $auth->requestPasswordReset('user@example.com');

// Reset password with token
$result = $auth->resetPassword('reset_token', 'new_password');

// Logout
$auth->logout();
```

### Book Service

Handles book catalog operations using the GraphQL Integration Service.

**Location:** `app/Services/BookService.php`

**Available Methods:**

```php
$books = new BookService();

// Get all books with filtering
$result = $books->getAllBooks(
    ['search' => 'Laravel', 'category' => 'Programming'],
    page: 1,
    perPage: 12
);

// Search books
$result = $books->search('PHP', page: 1, perPage: 12);

// Get book detail
$book = $books->getDetail(1);

// Get recommendations
$recommended = $books->getRecommendations(limit: 10);

// Get books by category
$categoryBooks = $books->getByCategory('Fiction', page: 1, perPage: 12);

// Get all categories
$categories = $books->getCategories();

// Check book availability
$availability = $books->checkAvailability(1);
```

### Borrowing Service

Handles book borrowing and transaction operations.

**Location:** `app/Services/BorrowingService.php`

**Available Methods:**

```php
$borrowing = new BorrowingService();

// Get user's borrowing history
$result = $borrowing->getBorrowings(page: 1, perPage: 10, status: 'active');

// Get active borrowings (currently borrowed)
$active = $borrowing->getActiveBorrowings();

// Get borrowing detail
$detail = $borrowing->getDetail(1);

// Borrow a book
$result = $borrowing->borrow(bookId: 1);

// Return a book
$result = $borrowing->return(borrowingId: 1);

// Get fines
$fines = $borrowing->getFines();

// Pay fine
$result = $borrowing->payFine(fineId: 1, amount: 50000);
```

## GraphQL Queries & Mutations

The `GraphQLQueries` class contains all GraphQL operations used by the frontend.

**Location:** `app/Services/GraphQLQueries.php`

### Member Service Mutations

**Login:**
```graphql
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
```

**Register:**
```graphql
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
```

### GraphQL Integration Service Queries

**Get Books:**
```graphql
query GetBooks(
    $page: Int
    $perPage: Int
    $search: String
    $category: String
    $author: String
    $year: Int
) {
    books(
        page: $page
        perPage: $perPage
        search: $search
        category: $category
        author: $author
        year: $year
    ) {
        data { ... }
        pagination { ... }
    }
}
```

**Get Borrowings:**
```graphql
query GetBorrowings(
    $page: Int
    $perPage: Int
    $status: String
) {
    borrowings(
        page: $page
        perPage: $perPage
        status: $status
    ) {
        data { ... }
        pagination { ... }
    }
}
```

## Usage Examples in Controllers

### Authentication Controller

```php
use App\Services\AuthService;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Call Member Service API
        $result = $this->authService->login($email, $password);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        // User data and token automatically stored in session
        return redirect()->to('/member/dashboard');
    }
}
```

### Book Controller

```php
use App\Services\BookService;

class BookController extends BaseController
{
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks([], page: 1, perPage: 12);
        
        return view('books/index', ['books' => $books]);
    }

    public function search()
    {
        $query = $this->request->getGet('q');
        $results = $this->bookService->search($query);
        
        return view('books/search', ['results' => $results]);
    }
}
```

### Member Dashboard Controller

```php
use App\Services\BorrowingService;

class MemberController extends BaseController
{
    protected BorrowingService $borrowingService;

    public function __construct()
    {
        $this->borrowingService = new BorrowingService();
    }

    public function dashboard()
    {
        // Get user's active borrowings
        $activeBorrowings = $this->borrowingService->getActiveBorrowings();
        
        // Get full borrowing history
        $history = $this->borrowingService->getBorrowings(page: 1, perPage: 10);
        
        return view('member/dashboard', [
            'active' => $activeBorrowings,
            'history' => $history,
        ]);
    }

    public function borrow()
    {
        $bookId = $this->request->getPost('book_id');
        $result = $this->borrowingService->borrow($bookId);
        
        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }
        
        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }
}
```

## Error Handling

The API client automatically handles errors:

1. **401 Unauthorized** - Session is destroyed, user is logged out
2. **Network Errors** - Logged and returns null
3. **GraphQL Errors** - Returned in response for handling

**Example Error Handling:**

```php
$result = $authService->login($email, $password);

if (!$result) {
    // Network error or API down
    return redirect()->back()->with('error', 'Server error. Please try again.');
}

if (!$result['success']) {
    // API returned error
    return redirect()->back()->with('error', $result['message']);
}

// Success
session()->set('jwt_token', $result['token']);
```

## Session Management

- **JWT Token Storage:** `session()->set('jwt_token', $token)`
- **User Data Storage:** `session()->set('user', $userData)`
- **Login Status:** `session()->set('isLoggedIn', true)`
- **Logout:** `session()->destroy()`

## Testing GraphQL Endpoints

You can test the GraphQL endpoints directly:

**Member Service Test:**
```bash
curl -X POST http://127.0.0.1:8001/api/graphql \
  -H "Content-Type: application/json" \
  -d '{
    "query": "mutation Login($email: String!, $password: String!) { login(email: $email, password: $password) { success message token } }",
    "variables": {
      "email": "user@example.com",
      "password": "password"
    }
  }'
```

**GraphQL Integration Service Test (with token):**
```bash
curl -X POST http://127.0.0.1:8000/api/graphql \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "query": "query GetMe { me { id name email } }"
  }'
```

## Troubleshooting

### Issue: "Connection refused" error
- Check if backend services are running on correct ports
- Verify `.env` file has correct URLs
- Check firewall settings

### Issue: "Unauthorized" error (401)
- JWT token may be expired or invalid
- Check if token is properly stored in session
- Try logging in again

### Issue: "CORS" errors
- Backend needs CORS configuration enabled
- Check backend `.env` for CORS settings
- Verify frontend URL is whitelisted

### Issue: "GraphQL Error: Field 'X' not found"
- GraphQL schema may differ from expected queries
- Check backend GraphQL schema implementation
- Verify field names match exactly

## Next Steps

1. Set up environment variables in `.env`
2. Start all backend services
3. Start the frontend
4. Test login/registration at `http://localhost:8080/auth/login`
5. Test book browsing at `http://localhost:8080`
6. Test borrowing functionality in member dashboard

## Additional Resources

- [GraphQL Documentation](https://graphql.org/learn/)
- [CodeIgniter 4 HTTP Client](https://codeigniter.com/user_guide/libraries/http_client.html)
- [JWT Authentication](https://jwt.io/introduction)
- Backend GraphQL schemas in `Backend-Service/*/graphql/schema.graphql`
