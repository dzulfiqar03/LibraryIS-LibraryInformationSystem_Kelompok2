# Developer Reference Card - API Integration

## Quick Command Reference

### Start All Services

```bash
# Terminal 1: GraphQL Integration Service
cd Backend-Service/GraphQL-Integration
php artisan serve --port=8000

# Terminal 2: Member Service (Auth)
cd Backend-Service/member-service
php artisan serve --port=8001

# Terminal 3: Book Service (Book)
cd Backend-Service/book-service
php artisan serve --port=8002

# Terminal 4: Transaction Service (transaction)
cd Backend-Service/transaction-service
php artisan serve --port=8003

# Terminal 5: Frontend
cd Frontend-Service/LibraryIS-app
php spark serve
```

## Service URLs

| Service             | URL                               | Purpose         |
| ------------------- | --------------------------------- | --------------- |
| Frontend            | http://localhost:8080             | Web app         |
| GraphQL Integration | http://127.0.0.1:8000/api/graphql | Main API        |
| Member Service      | http://127.0.0.1:8001/api/graphql | Auth API        |
| Book Service        | http://127.0.0.1:8002/api/graphql | Book API        |
| Transaction Service | http://127.0.0.1:8003/api/graphql | Transaction API |
| Database            | localhost:3306                    | MySQL           |

## Configuration

### .env Setup

```env
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql
BOOK_SERVICE_URL = http://127.0.0.1:8002/api/graphql
TRANSACTION_SERVICE_URL = http://127.0.0.1:8003/api/graphql
API_TIMEOUT = 10
```

## Code Snippets

### Use in Controller

```php
use App\Services\AuthService;
use App\Services\BookService;
use App\Services\BorrowingService;

public function example()
{
    // Authentication
    $auth = new AuthService();
    $result = $auth->login('email@test.com', 'password');

    // Books
    $books = new BookService();
    $allBooks = $books->getAllBooks(['category' => 'Fiction']);
    $bookDetail = $books->getDetail(1);

    // Borrowing
    $borrowing = new BorrowingService();
    $myBooks = $borrowing->getActiveBorrowings();
    $borrowResult = $borrowing->borrow(bookId: 1);
}
```

### Check Authentication

```php
// Check if user is logged in
if (session()->has('jwt_token')) {
    $token = session()->get('jwt_token');
    $user = session()->get('user');
    // User is authenticated
}

// Check via AuthService
$auth = new AuthService();
if ($auth->isAuthenticated()) {
    // User is authenticated
}
```

### Handle API Responses

```php
$result = $auth->login($email, $password);

if (!$result) {
    // Network error
    return redirect()->back()->with('error', 'Server error');
}

if (!$result['success']) {
    // API returned error
    return redirect()->back()->with('error', $result['message']);
}

// Success
$userData = $result['user'];
$token = $result['token'];
```

### Use GraphQL Directly

```php
use App\Services\ApiClient;
use App\Services\GraphQLQueries;

$api = new ApiClient();

// Query books
$response = $api->graphql(
    GraphQLQueries::getBooks(),
    ['page' => 1, 'perPage' => 12]
);

if ($response && isset($response['data']['books'])) {
    $books = $response['data']['books'];
}

// Borrow book (requires token)
$response = $api->graphql(
    GraphQLQueries::borrowBook(),
    ['bookId' => '1']
);
```

## GraphQL Query Examples

### Get Books

```graphql
query {
  books {
      booksList {
          id
          title
          book_detail{
              authors
              isbn
              publisher
              publication_year
              category
              description
              pages
              quantity
              languages
              url_cover
              url_ebook
              status
          }
    }
  }

```

### Search Books

```graphql
 book(id: int $id) {
    id
    title
    book_detail{
      authors
      isbn
      publisher
      publication_year
      category
      description
      pages
      quantity
      languages
      url_cover
      url_ebook
      status
    }
}
}
```

### Input Book

```
mutation {
  createBook(
    input: {
      title: String
      detail: {
        authors: String
        isbn: String
        publisher: String
        publication_year: Int
        category: String
        description: String
        pages: Int
        quantity: Int
        languages: String
        status: String
      }
    }
  ) {
    message
    data{
        id
        title
        book_detail{
            authors
            isbn
            publisher
            publication_year
            category
            description
            pages
            quantity
            languages
            status
        }
    }
  }
}

```

### Update Book

```
mutation {
  updateBook(id: 38,
    input: {
      title: String
      detail: {
        authors: String
        isbn: String
        publisher: String
        publication_year: Int
        category: String
        description: String
        pages: Int
        quantity: Int
        languages: String
        status: String
      }
    }
  ) {
    message
    data{
        id
        title
        book_detail{
            authors
            isbn
            publisher
            publication_year
            category
            description
            pages
            quantity
            languages
            status
        }
    }
  }
}

```

### Create Transaction

```
mutation {
    createTransaction(
    input: {
      id_member: String
      transaction_date: String
      books:[{
          id_book: Int
          price: Float
          quantity: Int
      }]
    }
  ) {
    message
    data{
        id_member
        id
        transaction_details{
            id
            id_book
            id_transaction
            price
            quantity
        }
    }
  }
}


```

### Update transaction

```
mutation {
    updateTransaction(id: ID,
    input: {
      id_member: String
      transaction_date: String
      books:[{
          id_book: Int
          price: Float
          quantity: Int
      }]
    }
  ) {
    message
    data{
        id_member
        id
        transaction_details{
            id
            id_book
            id_transaction
            price
            quantity
        }
    }
  }
}

```

## Curl Testing

### Test GraphQL Endpoint (Member Service)

```bash
curl -X POST http://127.0.0.1:8001/api/graphql \
  -H "Content-Type: application/json" \
  -d '{
    "query": "mutation Login(\$email: String!, \$password: String!) { login(email: \$email, password: \$password) { success token } }",
    "variables": {
      "email": "user@example.com",
      "password": "password123"
    }
  }'
```

### Test with JWT Token (GraphQL Integration)

```bash
curl -X POST http://127.0.0.1:8000/api/graphql \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "query": "{ me { id name email } }"
  }'
```

### Test Book Listing

```bash
curl -X POST http://127.0.0.1:8000/api/graphql \
  -H "Content-Type: application/json" \
  -d '{
    "query": "query { books(page: 1, perPage: 10) { data { id title author } } }"
  }'
```

## Session Management

### Session Keys

```php
$_SESSION['jwt_token']     // JWT authentication token
$_SESSION['user']          // User object with id, name, email
$_SESSION['isLoggedIn']    // Boolean flag
```

### Set Session

```php
session()->set('jwt_token', $token);
session()->set('user', $userData);
session()->set('isLoggedIn', true);
```

### Get Session

```php
$token = session()->get('jwt_token');
$user = session()->get('user');
```

### Check Session

```php
if (session()->has('jwt_token')) {
    // Token exists
}
```

### Clear Session

```php
session()->remove('jwt_token');
session()->destroy();
```

## Common Issues

### Issue: Connection Refused

```bash
# Check if services are running
netstat -an | grep LISTEN

# Kill process on port
# Windows:
netstat -ano | findstr :8000
taskkill /PID <PID> /F

# Linux/Mac:
lsof -i :8000
kill -9 <PID>
```

### Issue: CORS Error

- Check backend CORS configuration
- Verify frontend URL is whitelisted
- Add to backend .env: `APP_URL=http://localhost:8080`

### Issue: Token Expired

```php
// Force user to login again
if ($response && isset($response['error'])) {
    session()->destroy();
    return redirect()->to('/auth/login');
}
```

### Issue: Database Connection

```bash
# Test MySQL connection
mysql -h localhost -u root -p

# Check .env credentials
# Run migrations
php artisan migrate

# Seed data
php artisan db:seed
```

## Debugging

### Enable Debug Mode

```env
CI_ENVIRONMENT = development
```

### Check Logs

```bash
# Frontend logs
tail -f Frontend-Service/LibraryIS-app/storage/logs/laravel.log

# Backend logs
tail -f Backend-Service/member-service/storage/logs/laravel.log
```

### Use Tinker (Laravel)

```bash
cd Backend-Service/member-service
php artisan tinker

# Test queries
$users = App\Models\User::all();
$users->first();
```

## File Structure

```
Frontend-Service/LibraryIS-app/
├── app/Services/
│   ├── ApiClient.php           # HTTP client
│   ├── AuthService.php         # Auth logic
│   ├── BookService.php         # Book queries
│   ├── BorrowingService.php    # Borrowing logic
│   └── GraphQLQueries.php      # All queries
├── app/Controllers/Auth/
│   └── AuthController.php      # Auth controller
├── .env                        # Configuration
└── storage/logs/
    └── laravel.log            # Application log
```

## Service Methods

### AuthService

```php
$auth = new AuthService();
$auth->login($email, $password);
$auth->register($userData);
$auth->getCurrentUser();
$auth->updateProfile($data);
$auth->changePassword($old, $new);
$auth->requestPasswordReset($email);
$auth->resetPassword($token, $password);
$auth->logout();
$auth->isAuthenticated();
```

### BookService

```php
$books = new BookService();
$books->getAllBooks($filters, $page, $perPage);
$books->search($query, $page, $perPage);
$books->getDetail($bookId);
$books->getRecommendations($limit);
$books->getByCategory($category, $page, $perPage);
$books->getCategories();
$books->checkAvailability($bookId);
```

### BorrowingService

```php
$borrowing = new BorrowingService();
$borrowing->getBorrowings($page, $perPage, $status);
$borrowing->getActiveBorrowings();
$borrowing->getDetail($borrowingId);
$borrowing->borrow($bookId);
$borrowing->return($borrowingId);
```

### ApiClient

```php
$api = new ApiClient();
$api->graphql($query, $variables);
$api->memberGraphql($query, $variables);
$api->setToken($token);
$api->getToken();
$api->clearToken();
```

## Routes

```
GET  /                          # Homepage
GET  /auth/login               # Login page
POST /auth/login-process       # Process login
GET  /auth/register            # Register page
POST /auth/register-process    # Process registration
GET  /auth/logout              # Logout
GET  /member/dashboard         # Member dashboard
POST /member/borrow            # Borrow book
```

## Response Format

### Success Response

```json
{
  "data": {
    "fieldName": {
      "success": true,
      "message": "Success",
      "token": "eyJ...",
      "user": { ... }
    }
  },
  "errors": []
}
```

### Error Response

```json
{
  "errors": [
    {
      "message": "Error description",
      "extensions": {
        "code": "ERROR_CODE"
      }
    }
  ]
}
```

## Quick Test

1. Start all services (4 terminals)
2. Visit http://localhost:8080/auth/login
3. Use test credentials
4. Should redirect to dashboard
5. Check browser dev tools → Application → Cookies
6. Look for session cookie with jwt_token

## Documentation Files

| File                       | Purpose         | Read Time |
| -------------------------- | --------------- | --------- |
| QUICK_START.md             | Fast start      | 5 min     |
| ARCHITECTURE_DIAGRAMS.md   | System diagrams | 10 min    |
| API_INTEGRATION_GUIDE.md   | Complete guide  | 30 min    |
| BACKEND_SETUP_CHECKLIST.md | Setup steps     | 60 min    |
| INTEGRATION_SUMMARY.md     | What changed    | 15 min    |

---

**Tip:** Keep this file open while developing!
