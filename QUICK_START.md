# Quick Start Guide - Backend API Integration

## Start Services (4 Terminal Windows)

### Terminal 1: GraphQL Integration Service (Port 8000)
```bash
cd Backend-Service/GraphQL-Integration
php artisan serve --port=8000
```

### Terminal 2: Member Service (Port 8001)
```bash
cd Backend-Service/member-service
php artisan serve --port=8001
```

### Terminal 3: Book Service (Optional)
```bash
cd Backend-Service/book-service
php artisan serve --port=8002
```

### Terminal 4: Frontend
```bash
cd Frontend-Service/LibraryIS-app
php spark serve
```

## Check Services

```bash
# Check if ports are open
netstat -an | grep LISTEN

# Test GraphQL Integration Service
curl http://127.0.0.1:8000/api/graphql

# Test Member Service
curl http://127.0.0.1:8001/api/graphql
```

## Frontend Configuration

**File:** `Frontend-Service/LibraryIS-app/.env`

```env
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql
API_TIMEOUT = 10
```

## API Flow

### 1. User Registration/Login
- User submits credentials to `AuthController::loginProcess()`
- Controller calls `AuthService::login()`
- AuthService calls `ApiClient::memberGraphql()` → Member Service (Port 8001)
- Member Service returns JWT token
- Token stored in session via `ApiClient::setToken()`

### 2. Authenticated Requests
- Any service method checks session for JWT token
- Includes `Authorization: Bearer {token}` header
- Routes authenticated requests to `ApiClient::graphql()` → GraphQL Integration (Port 8000)
- GraphQL Integration Service validates token and processes request

## Key Files

| File | Purpose |
|------|---------|
| `app/Services/ApiClient.php` | HTTP client for GraphQL requests |
| `app/Services/AuthService.php` | Authentication logic |
| `app/Services/BookService.php` | Book catalog operations |
| `app/Services/BorrowingService.php` | Book borrowing operations |
| `app/Services/GraphQLQueries.php` | GraphQL queries/mutations |
| `app/Controllers/Auth/AuthController.php` | Auth controller with API integration |
| `.env` | Backend service URLs |

## Usage in Controllers

```php
use App\Services\AuthService;
use App\Services\BookService;
use App\Services\BorrowingService;

class MyController extends BaseController
{
    public function example()
    {
        // Authentication
        $auth = new AuthService();
        $user = $auth->getCurrentUser();
        
        // Books
        $books = new BookService();
        $bookList = $books->getAllBooks();
        
        // Borrowing
        $borrowing = new BorrowingService();
        $myBooks = $borrowing->getActiveBorrowings();
    }
}
```

## Test Login

1. Go to: `http://localhost:8080/auth/login`
2. Enter test credentials (seeded from backend)
3. Should redirect to dashboard
4. Check session for `jwt_token`

## Test Book Browsing

1. Go to: `http://localhost:8080` (after login)
2. Browse books from GraphQL Integration Service
3. Click book for details
4. Test search functionality

## Test Borrowing

1. Go to member dashboard (after login)
2. Click "Borrow" on any available book
3. See it in "My Borrowings"
4. Test return functionality

## Common Issues

| Issue | Solution |
|-------|----------|
| Connection refused | Check services are running: `netstat -an \| grep 800` |
| Unauthorized (401) | Token expired or not stored. Try logging in again |
| Token not in session | Check `AuthController::loginProcess()` is called |
| GraphQL schema error | Check backend GraphQL schema: `Backend-Service/*/graphql/schema.graphql` |
| CORS error | Backend needs CORS enabled for frontend URL |

## Queue Processing (Optional)

```bash
# Terminal: Transaction queue
cd Backend-Service/transaction-service
php artisan queue:work --queue=transaction.book

# Terminal: Book updates
cd Backend-Service/book-service
php artisan queue:work --queue=book.update
```

## Database Seeding

```bash
# Seed all services with test data
cd Backend-Service/member-service && php artisan db:seed
cd Backend-Service/book-service && php artisan db:seed
cd Backend-Service/transaction-service && php artisan db:seed
cd Backend-Service/GraphQL-Integration && php artisan db:seed
```

## API Response Format

All responses follow GraphQL format with `data` and `errors` fields:

```json
{
  "data": {
    "fieldName": {
      "success": true,
      "message": "Success message",
      "result": {}
    }
  },
  "errors": []
}
```

If query fails:
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

## Session Management

- **Token key:** `jwt_token`
- **User data key:** `user`
- **Login status key:** `isLoggedIn`

```php
// Check if logged in
if (session()->has('jwt_token')) {
    // Authenticated
}

// Get current token
$token = session()->get('jwt_token');

// Get user data
$user = session()->get('user');
```

## Debugging Tips

1. **Check Laravel logs:**
   ```bash
   cd Frontend-Service/LibraryIS-app
   tail -f storage/logs/laravel.log
   ```

2. **Enable debug mode in `.env`:**
   ```env
   CI_ENVIRONMENT = development
   ```

3. **Test GraphQL directly:**
   ```bash
   # Using curl
   curl -X POST http://127.0.0.1:8000/api/graphql \
     -H "Authorization: Bearer YOUR_TOKEN" \
     -d '{"query":"query{me{id name}}"}'
   ```

4. **Check token validity:**
   ```php
   // In any controller
   $token = session()->get('jwt_token');
   if (!$token) {
       echo "No token in session";
   } else {
       echo "Token: " . substr($token, 0, 20) . "...";
   }
   ```

## Next Steps

1. Start all 4 services (4 terminal windows)
2. Configure `.env` with backend URLs
3. Test login at `/auth/login`
4. Test book browsing at homepage
5. Read `API_INTEGRATION_GUIDE.md` for detailed documentation
6. Review `BACKEND_SETUP_CHECKLIST.md` for complete setup

---

**For detailed documentation:** See `API_INTEGRATION_GUIDE.md`
**For complete setup:** See `BACKEND_SETUP_CHECKLIST.md`
