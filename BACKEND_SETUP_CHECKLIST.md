# Backend API Integration Setup Checklist

## Prerequisites
- [ ] PHP 8.0+ installed
- [ ] Composer installed
- [ ] Node.js & npm installed
- [ ] MySQL server running
- [ ] All backend services cloned/available

## Backend Services Setup

### 1. Member Service (Port 8001)
```bash
cd Backend-Service/member-service

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env

# Configure database
# Edit .env: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migrations
php artisan migrate

# Seed data (optional)
php artisan db:seed

# Start service
php artisan serve --port=8001
```
- [ ] Database configured
- [ ] Migrations completed
- [ ] Service running on port 8001
- [ ] Test GraphQL endpoint: http://127.0.0.1:8001/api/graphql

### 2. Book Service (Port 8002 or separate)
```bash
cd Backend-Service/book-service

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env

# Configure database
# Edit .env: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migrations
php artisan migrate

# Seed books data
php artisan db:seed

# Start service
php artisan serve --port=8002
```
- [ ] Database configured
- [ ] Migrations completed
- [ ] Books seeded in database
- [ ] Service running

### 3. Transaction Service
```bash
cd Backend-Service/transaction-service

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env

# Configure database & queue
# Edit .env: DB settings and QUEUE_CONNECTION=rabbitmq

# Run migrations
php artisan migrate

# Start queue worker
php artisan queue:work --queue=transaction.book
```
- [ ] Database configured
- [ ] RabbitMQ configured (if using)
- [ ] Queue worker running

### 4. GraphQL Integration Service (Port 8000)
```bash
cd Backend-Service/GraphQL-Integration

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env

# Configure to point to other services
# Edit .env: Service URLs/connections

# Run migrations (if needed)
php artisan migrate

# Start service
php artisan serve --port=8000
```
- [ ] Dependencies installed
- [ ] All service URLs configured in .env
- [ ] Migrations completed
- [ ] Service running on port 8000
- [ ] Test GraphQL endpoint: http://127.0.0.1:8000/api/graphql

## Frontend Setup

### 1. Environment Configuration
```bash
cd Frontend-Service/LibraryIS-app

# Copy environment file
cp .env.example .env
```

**Update .env with backend URLs:**
```env
# Add these to your .env file:
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql
API_TIMEOUT = 10
```
- [ ] .env file created
- [ ] Backend URLs configured correctly

### 2. Install Frontend Dependencies
```bash
cd Frontend-Service/LibraryIS-app

# Install Composer dependencies
composer install

# Install npm dependencies
npm install

# Build assets
npm run dev
```
- [ ] Composer dependencies installed
- [ ] npm dependencies installed
- [ ] Assets built

### 3. Configure Database (if needed)
```bash
# Update .env with database credentials
# Only needed if frontend uses local database for sessions
```
- [ ] Database configured (if using)
- [ ] Migrations completed (if needed)

### 4. Start Frontend
```bash
cd Frontend-Service/LibraryIS-app

php spark serve
```
- [ ] Frontend running on http://localhost:8080

## Verification Tests

### 1. Member Service Tests
```bash
# Test login endpoint
curl -X POST http://127.0.0.1:8001/api/graphql \
  -H "Content-Type: application/json" \
  -d '{
    "query": "mutation { login(email: \"test@example.com\", password: \"password\") { success token } }"
  }'
```
- [ ] Login query returns token
- [ ] Registration works

### 2. GraphQL Integration Service Tests
```bash
# Test with JWT token
curl -X POST http://127.0.0.1:8000/api/graphql \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "query": "query { me { id name email } }"
  }'
```
- [ ] Returns user data with valid token
- [ ] Returns 401 without token

### 3. Frontend Tests
```
http://localhost:8080/
```
- [ ] Homepage loads
- [ ] Navigation works
- [ ] Login page accessible: http://localhost:8080/auth/login
- [ ] Registration page accessible: http://localhost:8080/auth/register

### 4. Authentication Flow Test
1. [ ] Navigate to login page
2. [ ] Enter test credentials
3. [ ] Should redirect to dashboard
4. [ ] Session should contain jwt_token
5. [ ] Dashboard should load user data

### 5. Book Browsing Test
1. [ ] Navigate to books section
2. [ ] Books should load from GraphQL service
3. [ ] Search functionality works
4. [ ] Pagination works
5. [ ] Book details page loads

### 6. Borrowing Test
1. [ ] User can borrow a book (if not already borrowed limit reached)
2. [ ] Borrowing confirmation shows
3. [ ] Book appears in "My Borrowings"
4. [ ] User can return borrowed book
5. [ ] Return confirmation shows

## RabbitMQ Setup (Optional but Recommended)

If using RabbitMQ for queue processing:

### 1. Install RabbitMQ
- Windows: [Download RabbitMQ](https://www.rabbitmq.com/download.html)
- Ubuntu/Debian: `sudo apt-get install rabbitmq-server`
- MacOS: `brew install rabbitmq`

### 2. Start RabbitMQ
```bash
# Windows
RabbitMQ Service is usually auto-started

# Linux
sudo service rabbitmq-server start

# MacOS
brew services start rabbitmq
```

### 3. Configure Backend Services
Update backend `.env` files:
```env
QUEUE_CONNECTION=rabbitmq
RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
```

### 4. Start Queue Workers
```bash
# Terminal 1: Transaction job queue
cd Backend-Service/transaction-service
php artisan queue:work --queue=transaction.book

# Terminal 2: Book update queue
cd Backend-Service/book-service
php artisan queue:work --queue=book.update

# Terminal 3: Book snapshot queue
cd Backend-Service/book-service
php artisan queue:work --queue=snapshot.book

# Terminal 4: Snapshot update queue
cd Backend-Service/transaction-service
php artisan queue:work --queue=snapshot.book.update
```

- [ ] RabbitMQ running on localhost:5672
- [ ] All queue workers started
- [ ] Queue messages processing correctly

## Service Architecture Summary

```
Frontend (localhost:8080)
  │
  ├─→ Member Service (localhost:8001)
  │   └─ Authentication
  │   └─ User Management
  │
  └─→ GraphQL Integration (localhost:8000)
      ├─ Book Service (Book queries)
      ├─ Transaction Service (Borrowing)
      └─ Member Service (User profile)
          ↓
      RabbitMQ (localhost:5672)
      └─ Async job processing
```

## Troubleshooting Common Issues

### Issue: "Connection refused" on port 8000/8001
- [ ] Check if services are running: `netstat -an | grep LISTEN`
- [ ] Check firewall settings
- [ ] Ensure ports are not in use by other services

### Issue: Database errors
- [ ] Check MySQL is running
- [ ] Verify credentials in .env
- [ ] Run migrations: `php artisan migrate`
- [ ] Check database exists: `php artisan db:show`

### Issue: JWT token not working
- [ ] Verify token is being stored in session
- [ ] Check if token is expired
- [ ] Verify Authorization header format: `Bearer TOKEN`
- [ ] Check backend JWT_SECRET is configured

### Issue: CORS errors
- [ ] Backend needs CORS middleware enabled
- [ ] Check if frontend URL is whitelisted in backend config
- [ ] Verify headers are correct in ApiClient

### Issue: GraphQL query errors
- [ ] Check query syntax against backend schema
- [ ] Verify all required variables are provided
- [ ] Check field names match exactly
- [ ] Review backend GraphQL schema documentation

## Next Steps

1. Complete all setup steps above
2. Run verification tests
3. Test authentication flow
4. Test book browsing
5. Test borrowing functionality
6. Review API_INTEGRATION_GUIDE.md for detailed usage
7. Check individual service documentation in Backend-Service

## Additional Commands

```bash
# View artisan commands
php artisan list

# Check database status
php artisan db:show

# Run specific migration
php artisan migrate:refresh --seed

# Clear cache
php artisan cache:clear

# View logs
tail -f storage/logs/laravel.log

# Tinker shell (test queries)
php artisan tinker
```

## Support

For issues or questions:
1. Check logs in `storage/logs/`
2. Review Backend-Service README files
3. Check Backend-Service/*/graphql/schema.graphql for available queries
4. Test endpoints with Postman/Insomnia

---

**Last Updated:** December 23, 2025
**Version:** 1.0
