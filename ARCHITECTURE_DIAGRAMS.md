# LibraryIS Backend Integration - System Architecture Diagrams

## 1. Overall System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                       LibraryIS Platform                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │            Frontend (CodeIgniter 4 + PHP)               │   │
│  │         http://localhost:8080                            │   │
│  │  ┌────────────────┬──────────────┬──────────────────┐   │   │
│  │  │ Auth Module    │ Book Module  │ Member Module    │   │   │
│  │  │ - Login        │ - Browse     │ - Dashboard      │   │   │
│  │  │ - Register     │ - Search     │ - Profile        │   │   │
│  │  │ - Password     │ - Details    │ - Borrowing      │   │   │
│  │  │   Reset        │              │                  │   │   │
│  │  └────────────────┴──────────────┴──────────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                           │                                       │
│                           │ GraphQL                               │
│        ┌──────────────────┴────────────────────┐                 │
│        │                                       │                 │
│        ▼                                       ▼                 │
│  ┌──────────────────────┐         ┌──────────────────────┐      │
│  │  Member Service      │         │  GraphQL Integration │      │
│  │  (Port 8001)         │         │  Service (Port 8000) │      │
│  │                      │         │                      │      │
│  │ - User Registration  │         │ - Books API          │      │
│  │ - Authentication     │         │ - Borrowing API      │      │
│  │ - JWT Tokens         │         │ - Transactions API   │      │
│  │ - Profile Mgmt       │         │ - Member Service     │      │
│  │ - Password Reset     │         │   Integration        │      │
│  └──────────────────────┘         └──────────┬───────────┘      │
│         │                                     │                 │
│         │ MySQL DB                           │                 │
│         ▼                                     ▼                 │
│  ┌──────────────────┐         ┌─────────────────────────┐      │
│  │ Member Database  │         │ Book Service Backend    │      │
│  │ - users          │         │ (Port 8002 or via 8000) │      │
│  │ - sessions       │         │ - Books DB              │      │
│  │ - tokens         │         │ - Inventory             │      │
│  └──────────────────┘         └─────────┬───────────────┘      │
│                                          │                      │
│                                          ▼                      │
│                              ┌──────────────────────┐            │
│                              │ Transaction Service  │            │
│                              │ (Port 8003 or Queue) │            │
│                              │ - Borrowings         │            │
│                              │ - Returns            │            │
│                              │ - Fines              │            │
│                              └─────────┬────────────┘            │
│                                        │                        │
│                                        ▼                        │
│                              ┌──────────────────┐               │
│                              │  RabbitMQ Queue  │               │
│                              │  (async jobs)    │               │
│                              └──────────────────┘               │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

## 2. Authentication Flow

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │
       │ 1. User enters email & password
       │    on http://localhost:8080/auth/login
       │
       ▼
┌──────────────────────────────┐
│  AuthController              │
│  ::loginProcess()            │
└──────────────────┬───────────┘
                   │
                   │ 2. Validates input
                   │
                   ▼
┌──────────────────────────────┐
│  AuthService                 │
│  ::login($email, $password)  │
└──────────────────┬───────────┘
                   │
                   │ 3. Calls GraphQL mutation
                   │
                   ▼
┌──────────────────────────────┐
│  ApiClient                   │
│  ::memberGraphql()           │
│  (Member Service - Port 8001)│
└──────────────────┬───────────┘
                   │
                   │ 4. HTTP POST with GraphQL
                   │    {
                   │      "query": "mutation Login {...}",
                   │      "variables": {
                   │        "email": "user@example.com",
                   │        "password": "password"
                   │      }
                   │    }
                   │
                   ▼
┌──────────────────────────────┐
│  Member Service              │
│  (Port 8001)                 │
│                              │
│  1. Validates credentials    │
│  2. Generates JWT token      │
│  3. Returns token + user     │
└──────────────────┬───────────┘
                   │
                   │ 5. Response:
                   │    {
                   │      "data": {
                   │        "login": {
                   │          "success": true,
                   │          "token": "eyJ...",
                   │          "user": {
                   │            "id": 1,
                   │            "name": "John",
                   │            "email": "john@..."
                   │          }
                   │        }
                   │      }
                   │    }
                   │
                   ▼
┌──────────────────────────────┐
│  ApiClient                   │
│  ::setToken($token)          │
│                              │
│  Stores in session:          │
│  $_SESSION['jwt_token']      │
└──────────────────┬───────────┘
                   │
                   │ 6. AuthController stores user data
                   │    $_SESSION['user'] = $userData
                   │
                   ▼
┌──────────────────────────────┐
│  Redirect to:                │
│  /member/dashboard           │
│                              │
│  Session now contains:       │
│  - jwt_token                 │
│  - user (id, name, email)    │
│  - isLoggedIn = true         │
└──────────────────────────────┘
```

## 3. Authenticated Request Flow

```
┌─────────────────────────────────┐
│  Frontend Controller Action     │
│  (requires authentication)      │
└──────────────┬──────────────────┘
               │
               │ 1. Calls service method
               │    $bookService->getAllBooks()
               │
               ▼
┌─────────────────────────────────┐
│  Service Class                  │
│  (BookService, etc)             │
└──────────────┬──────────────────┘
               │
               │ 2. Calls ApiClient
               │    $api->graphql($query, $vars)
               │
               ▼
┌─────────────────────────────────┐
│  ApiClient                      │
│  ::graphql()                    │
│                                 │
│  1. Gets token from session:    │
│     $this->token =              │
│     session('jwt_token')        │
│                                 │
│  2. Calls getHeaders()          │
│     which adds Authorization    │
│     header with Bearer token    │
└──────────────┬──────────────────┘
               │
               │ 3. HTTP POST to GraphQL Integration
               │    Service (Port 8000)
               │
               │    Headers:
               │    - Content-Type: application/json
               │    - Authorization: Bearer {token}
               │
               │    Body:
               │    {
               │      "query": "query GetBooks(...)",
               │      "variables": {...}
               │    }
               │
               ▼
┌─────────────────────────────────┐
│  GraphQL Integration Service    │
│  (Port 8000)                    │
│                                 │
│  1. Receives request            │
│  2. Validates JWT token         │
│  3. Extracts user from token    │
│  4. Executes query              │
│  5. Returns results             │
└──────────────┬──────────────────┘
               │
               │ 4. Response (GraphQL format)
               │    {
               │      "data": {
               │        "books": {
               │          "data": [...],
               │          "pagination": {...}
               │        }
               │      }
               │    }
               │
               ▼
┌─────────────────────────────────┐
│  Service processes response     │
│  and returns to controller      │
│                                 │
│  Controller displays data       │
│  in view                        │
└─────────────────────────────────┘
```

## 4. Session & Token Management

```
┌────────────────────────────────────────────────────────┐
│              $_SESSION Array                           │
├────────────────────────────────────────────────────────┤
│                                                         │
│  'jwt_token'  → "eyJhbGciOiJIUzI1NiIsInR..."          │
│                (JWT token from Member Service)        │
│                                                         │
│  'user'       → {                                      │
│                  'id'       => 1,                      │
│                  'name'     => 'John Doe',             │
│                  'email'    => 'john@example.com',    │
│                  'phone'    => '081234567890',         │
│                  'address'  => 'Jl. Example'          │
│                }                                       │
│                                                         │
│  'isLoggedIn' → true                                   │
│                                                         │
│  'PHPSESSID'  → "session_identifier"                   │
│                (Stored in writable/session/)           │
│                                                         │
└────────────────────────────────────────────────────────┘
                        │
                        │ Read by ApiClient
                        │
                        ▼
┌────────────────────────────────────────────────────────┐
│           ApiClient::getHeaders()                      │
│                                                         │
│  Returns:                                              │
│  [                                                     │
│    'Content-Type' => 'application/json',              │
│    'Accept' => 'application/json',                    │
│    'Authorization' => 'Bearer eyJhbGciOi...'          │
│  ]                                                     │
│                                                         │
│  The token is automatically included in               │
│  all requests to GraphQL Integration Service           │
└────────────────────────────────────────────────────────┘
```

## 5. Service Interaction - Borrowing Flow

```
┌──────────────────┐
│ Member Dashboard │
│ "Borrow Book"    │
└────────┬─────────┘
         │
         │ POST /borrow (with book_id)
         │
         ▼
┌──────────────────────────────┐
│ BorrowingController          │
│ ::borrowProcess()            │
└────────────┬────────────────┘
             │
             │ Calls BorrowingService::borrow()
             │
             ▼
┌──────────────────────────────┐
│ BorrowingService             │
│ ::borrow()                   │
└────────────┬────────────────┘
             │
             │ Sends GraphQL mutation to
             │ GraphQL Integration Service
             │
             ▼
┌──────────────────────────────┐
│ GraphQL Integration (8000)   │
│                              │
│ mutation BorrowBook {        │
│   borrowBook(bookId: 1) {    │
│     success                  │
│     message                  │
│     borrowing { ... }        │
│   }                          │
│ }                            │
└────────────┬────────────────┘
             │
             │ Routes to Book Service
             │ (internal, behind 8000)
             │
             ▼
┌──────────────────────────────┐
│ Book Service (Backend)       │
│                              │
│ 1. Check if book available   │
│ 2. Create borrowing record   │
│ 3. Emit event/trigger job    │
└────────────┬────────────────┘
             │
             │ Emits async job event
             │
             ▼
┌──────────────────────────────┐
│ RabbitMQ Queue               │
│ transaction.book queue       │
│                              │
│ Job: BorrowBookJob           │
│ - Update inventory           │
│ - Send notifications         │
│ - Log transaction            │
└────────────┬────────────────┘
             │
             │ Worker processes:
             │ php artisan queue:work \
             │   --queue=transaction.book
             │
             ▼
┌──────────────────────────────┐
│ Transaction Service Worker   │
│                              │
│ Processes async work         │
└──────────────────────────────┘
```

## 6. Port Summary

```
┌─────────────────────────────────────────────┐
│           Service Port Overview             │
├─────────────────────────────────────────────┤
│                                             │
│  Frontend (CodeIgniter 4)                   │
│  └─ Port 8080                               │
│     http://localhost:8080                   │
│                                             │
│  GraphQL Integration Service                │
│  └─ Port 8000                               │
│     http://127.0.0.1:8000/api/graphql      │
│     └─ Internal routing to Book Service     │
│     └─ Internal routing to Transaction Srv  │
│     └─ Internal routing to Member Service   │
│                                             │
│  Member Service (Auth)                      │
│  └─ Port 8001                               │
│     http://127.0.0.1:8001/api/graphql      │
│     └─ User registration                    │
│     └─ User authentication                  │
│     └─ Profile management                   │
│                                             │
│  Book Service (Optional, if separate)       │
│  └─ Port 8002 (or served via 8000)         │
│     └─ Book management                      │
│     └─ Inventory management                 │
│                                             │
│  Database Services                          │
│  └─ MySQL Port 3306 (localhost)             │
│     └─ Multiple databases for each service  │
│                                             │
│  Message Queue (Optional)                   │
│  └─ RabbitMQ Port 5672                     │
│     └─ Async job processing                 │
│     └─ Queue workers consume messages       │
│                                             │
└─────────────────────────────────────────────┘
```

## 7. API Request Response Cycle

```
Request:
┌────────────────────────────────────────────┐
│ POST /api/graphql                          │
│ Content-Type: application/json             │
│ Authorization: Bearer eyJhbGciOi...        │
│                                            │
│ {                                          │
│   "query": "query GetBooks(...) { ... }",  │
│   "variables": {                           │
│     "page": 1,                             │
│     "perPage": 12                          │
│   }                                        │
│ }                                          │
└────────────────────────────────────────────┘
              │
              │ HTTP/1.1 200 OK
              │
              ▼
Response:
┌────────────────────────────────────────────┐
│ {                                          │
│   "data": {                                │
│     "books": {                             │
│       "data": [                            │
│         {                                  │
│           "id": "1",                       │
│           "title": "Laravel Guide",        │
│           "author": "John Doe",            │
│           "category": "Programming",       │
│           "availableCopies": 3,            │
│           "totalCopies": 5,                │
│           "coverImage": "..."              │
│         },                                 │
│         ...                                │
│       ],                                   │
│       "pagination": {                      │
│         "total": 150,                      │
│         "perPage": 12,                     │
│         "currentPage": 1,                  │
│         "lastPage": 13,                    │
│         "from": 1,                         │
│         "to": 12                           │
│       }                                    │
│     }                                      │
│   },                                       │
│   "errors": []                             │
│ }                                          │
└────────────────────────────────────────────┘
```

## 8. Error Handling Flow

```
┌───────────────────────┐
│ API Request Fails     │
└───────────┬───────────┘
            │
            ├─→ Network Error
            │   ├─→ ApiClient catches exception
            │   ├─→ Logs to storage/logs/
            │   ├─→ Returns null
            │   └─→ Controller shows error message
            │
            ├─→ HTTP 401 Unauthorized
            │   ├─→ Token invalid/expired
            │   ├─→ ApiClient clears session
            │   ├─→ Returns null
            │   └─→ User redirected to login
            │
            ├─→ HTTP 4xx Client Error
            │   ├─→ Logged as warning
            │   ├─→ Response body returned
            │   └─→ Controller handles error
            │
            └─→ HTTP 5xx Server Error
                ├─→ Logged as error
                ├─→ Response body returned
                └─→ User sees error message
```

---

These diagrams show the complete flow of how the frontend integrates with the backend services using GraphQL and JWT authentication.
