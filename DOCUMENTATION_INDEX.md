# LibraryIS Backend Integration - Complete Documentation Index

## 📚 Documentation Overview

This documentation provides complete information on how the LibraryIS frontend integrates with the backend services using GraphQL API and JWT authentication.

---

## 🚀 Quick Start (5 Minutes)

Start here if you just want to get everything running:

**File:** [QUICK_START.md](QUICK_START.md)

### What's Included:
- Start services in 4 terminal windows
- Port configuration checklist
- Basic testing procedures
- Common issues quick fixes

---

## 🏗️ System Architecture

Understand how everything is connected:

**File:** [ARCHITECTURE_DIAGRAMS.md](ARCHITECTURE_DIAGRAMS.md)

### What's Included:
- Overall system architecture diagram
- Authentication flow visualization
- Authenticated request flow
- Session & token management diagram
- Service interaction flows
- Port summary table
- API request/response cycle
- Error handling flow

---

## 📋 Complete Integration Guide

Comprehensive documentation for all integration details:

**File:** [API_INTEGRATION_GUIDE.md](API_INTEGRATION_GUIDE.md)

### Sections:
1. **Architecture & Overview**
   - Backend services descriptions
   - Authentication flow

2. **Getting Started**
   - Environment configuration
   - Starting all services
   - Frontend startup

3. **API Integration Details**
   - ApiClient service methods
   - AuthService methods
   - BookService methods
   - BorrowingService methods
   - All available GraphQL queries

4. **Usage Examples**
   - Controller implementation examples
   - Error handling patterns
   - Session management

5. **Testing & Troubleshooting**
   - Direct GraphQL endpoint testing
   - Common issues and solutions

---

## ☑️ Backend Setup Checklist

Step-by-step setup for all backend services:

**File:** [BACKEND_SETUP_CHECKLIST.md](BACKEND_SETUP_CHECKLIST.md)

### What's Covered:
1. **Member Service Setup** (Port 8001)
   - Environment setup
   - Database configuration
   - Migrations and seeding
   - Service startup

2. **Book Service Setup**
   - Dependencies installation
   - Database configuration
   - Book seeding

3. **Transaction Service Setup**
   - Queue configuration
   - RabbitMQ setup

4. **GraphQL Integration Setup** (Port 8000)
   - Configuration
   - Migrations

5. **Frontend Setup**
   - Environment configuration
   - Dependencies installation
   - Startup instructions

6. **Verification Tests**
   - Test each service individually
   - Test end-to-end flows
   - Test authentication
   - Test book browsing
   - Test borrowing

7. **RabbitMQ Setup** (Optional)
   - Installation
   - Configuration
   - Queue workers startup

8. **Troubleshooting Guide**
   - Connection issues
   - Database errors
   - JWT token issues
   - CORS errors
   - GraphQL errors

---

## ⚙️ Environment Configuration

Configuration details and examples:

**File:** [Frontend-Service/LibraryIS-app/ENV_EXAMPLE_DETAILED.md](Frontend-Service/LibraryIS-app/ENV_EXAMPLE_DETAILED.md)

### What's Included:
- Complete .env example with all options
- API service URL configuration
- Database setup for different scenarios
- Session configuration options
- Security settings (development vs production)
- Mail configuration for password reset
- Cache configuration
- Logging settings

---

## 📊 Implementation Summary

Complete overview of what was implemented:

**File:** [INTEGRATION_SUMMARY.md](INTEGRATION_SUMMARY.md)

### What's Included:
1. **What Has Been Done** - All changes made
2. **Architecture Overview** - Service interactions
3. **Authentication Flow** - Detailed flow diagram
4. **How It Works** - Step-by-step explanations
5. **Changes from Original** - Before/after comparison
6. **Starting Everything** - Service startup commands
7. **Key Features** - List of implemented features
8. **Next Steps** - For different team roles

---

## 🔧 Technical Details

### Services Implemented

#### ApiClient Service
- **File:** `Frontend-Service/LibraryIS-app/app/Services/ApiClient.php`
- **Features:**
  - GraphQL query execution
  - JWT token management
  - Automatic Bearer token inclusion
  - Error handling and logging
  - Response parsing

#### AuthService
- **File:** `Frontend-Service/LibraryIS-app/app/Services/AuthService.php`
- **Features:**
  - User registration via GraphQL
  - User login with JWT token
  - Profile management
  - Password reset flows
  - Authentication status checking

#### BookService
- **File:** `Frontend-Service/LibraryIS-app/app/Services/BookService.php`
- **Features:**
  - Book listing with pagination
  - Book search functionality
  - Book details retrieval
  - Category management
  - Book availability checking
  - Book recommendations

#### BorrowingService
- **File:** `Frontend-Service/LibraryIS-app/app/Services/BorrowingService.php`
- **Features:**
  - Get borrowing history
  - Get active borrowings
  - Borrow books
  - Return books
  - Borrowing details retrieval

#### GraphQLQueries
- **File:** `Frontend-Service/LibraryIS-app/app/Services/GraphQLQueries.php`
- **Features:**
  - Centralized GraphQL queries
  - Member Service mutations (login, register, password reset)
  - Book queries
  - Borrowing queries and mutations
  - User profile queries

#### AuthController
- **File:** `Frontend-Service/LibraryIS-app/app/Controllers/Auth/AuthController.php`
- **Features:**
  - Login with real API integration
  - Registration with real API integration
  - Password reset workflow
  - Logout with token clearing
  - Proper session management

---

## 🔌 Backend Services

### Ports & Endpoints

| Service | Port | GraphQL Endpoint | Purpose |
|---------|------|------------------|---------|
| GraphQL Integration | 8000 | `http://127.0.0.1:8000/api/graphql` | Main API gateway |
| Member Service | 8001 | `http://127.0.0.1:8001/api/graphql` | Authentication & user mgmt |
| Book Service | 8002 | Behind port 8000 | Book catalog |
| Frontend | 8080 | `http://localhost:8080` | Web application |
| MySQL | 3306 | N/A | Database |
| RabbitMQ | 5672 | N/A | Message queue (optional) |

---

## 📁 Project Structure

### Frontend Files Modified/Created

```
Frontend-Service/LibraryIS-app/
├── app/
│   ├── Services/
│   │   ├── ApiClient.php                    ✅ Enhanced
│   │   ├── AuthService.php                  ✅ Enhanced
│   │   ├── BookService.php                  ✅ Enhanced
│   │   ├── BorrowingService.php             ✅ Enhanced
│   │   └── GraphQLQueries.php               ✨ New
│   └── Controllers/
│       └── Auth/
│           └── AuthController.php           ✅ Enhanced
├── .env.example                              ✅ Updated
├── ENV_EXAMPLE_DETAILED.md                   ✨ New
└── [See root for documentation]
```

### Root Documentation Files (Created)

```
Project Root/
├── QUICK_START.md                            ✨ New
├── INTEGRATION_SUMMARY.md                    ✨ New
├── BACKEND_SETUP_CHECKLIST.md               ✨ New
├── ARCHITECTURE_DIAGRAMS.md                 ✨ New
└── API_INTEGRATION_GUIDE.md                 ✨ New
```

---

## 🔑 Key Files Reference

### Frontend Services
| File | Purpose | Key Methods |
|------|---------|-------------|
| `ApiClient.php` | HTTP GraphQL client | `graphql()`, `memberGraphql()`, `setToken()` |
| `AuthService.php` | Authentication | `login()`, `register()`, `getCurrentUser()` |
| `BookService.php` | Book operations | `getAllBooks()`, `search()`, `getDetail()` |
| `BorrowingService.php` | Borrowing ops | `borrow()`, `return()`, `getActiveBorrowings()` |
| `GraphQLQueries.php` | Query library | Static methods for all GraphQL operations |
| `AuthController.php` | Auth controller | `loginProcess()`, `registerProcess()`, `logout()` |

### Configuration Files
| File | Purpose |
|------|---------|
| `.env` | Environment variables (copy from .env.example) |
| `ENV_EXAMPLE_DETAILED.md` | Detailed .env configuration guide |

---

## 🔐 Security Notes

### JWT Token Management
- Tokens are stored in `$_SESSION['jwt_token']`
- Automatically included in all authenticated requests
- Session-based storage (more secure than localStorage)
- Cleared on logout

### Session Protection
- CSRF protection enabled
- Session cookie httponly flag
- SameSite cookie policy
- IP matching disabled (for load balancers)

### HTTPS in Production
- Force HTTPS in production via `app.forceGlobalSecureRequests`
- Update all URLs to https://
- Configure CORS for your domain

---

## 🧪 Testing

### Manual Testing Steps

1. **Authentication Test**
   ```
   Go to: http://localhost:8080/auth/login
   Enter test credentials
   Should redirect to dashboard
   ```

2. **Book Browsing Test**
   ```
   Go to: http://localhost:8080
   Books should load from API
   Search should work
   Pagination should work
   ```

3. **Borrowing Test**
   ```
   Go to member dashboard
   Click borrow on any book
   Book should appear in "My Borrowings"
   Return functionality should work
   ```

### Automated Testing
GraphQL endpoints can be tested with:
- Postman
- Insomnia
- cURL commands
- See `API_INTEGRATION_GUIDE.md` for examples

---

## 🐛 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Port already in use | Change port number or kill existing process |
| Connection refused | Check service is running on correct port |
| 401 Unauthorized | JWT token expired, user needs to login again |
| CORS error | Check CORS configuration in backend |
| GraphQL schema error | Verify backend GraphQL schema matches queries |
| Database error | Check MySQL is running and .env credentials |
| Token not in session | Check AuthController is properly setting token |

**Full troubleshooting:** See respective documentation files

---

## 📞 Support & Resources

### Documentation Files
1. **[QUICK_START.md](QUICK_START.md)** - Fast start (5 min read)
2. **[API_INTEGRATION_GUIDE.md](API_INTEGRATION_GUIDE.md)** - Complete guide (30 min read)
3. **[BACKEND_SETUP_CHECKLIST.md](BACKEND_SETUP_CHECKLIST.md)** - Setup steps (60 min setup)
4. **[ARCHITECTURE_DIAGRAMS.md](ARCHITECTURE_DIAGRAMS.md)** - Visual diagrams
5. **[INTEGRATION_SUMMARY.md](INTEGRATION_SUMMARY.md)** - What was done

### Code Files
- Service classes: `app/Services/`
- Controller classes: `app/Controllers/Auth/`
- Configuration: `.env` file

### Logs
- Frontend logs: `storage/logs/laravel.log`
- Backend logs: Check respective `storage/logs/` directories

---

## 🚀 Workflow

### For First-Time Setup
1. Read [QUICK_START.md](QUICK_START.md) (5 min)
2. Read [ARCHITECTURE_DIAGRAMS.md](ARCHITECTURE_DIAGRAMS.md) (10 min)
3. Follow [BACKEND_SETUP_CHECKLIST.md](BACKEND_SETUP_CHECKLIST.md) (60 min)
4. Test everything as per checklist
5. Read [API_INTEGRATION_GUIDE.md](API_INTEGRATION_GUIDE.md) for details

### For Development
1. Start services (use [QUICK_START.md](QUICK_START.md))
2. Reference [API_INTEGRATION_GUIDE.md](API_INTEGRATION_GUIDE.md) for API usage
3. Check service files for available methods
4. Use [ARCHITECTURE_DIAGRAMS.md](ARCHITECTURE_DIAGRAMS.md) to understand flows

### For Debugging
1. Check logs in `storage/logs/`
2. Enable debug mode in `.env`
3. Use cURL to test GraphQL endpoints
4. Check [API_INTEGRATION_GUIDE.md](API_INTEGRATION_GUIDE.md) troubleshooting section
5. Review [ARCHITECTURE_DIAGRAMS.md](ARCHITECTURE_DIAGRAMS.md) for request flows

---

## ✅ Implementation Status

- ✅ **ApiClient** - GraphQL support + JWT handling
- ✅ **AuthService** - Full authentication integration
- ✅ **AuthController** - Real API calls + session management
- ✅ **BookService** - GraphQL queries for book operations
- ✅ **BorrowingService** - GraphQL queries for borrowing
- ✅ **GraphQLQueries** - Centralized query library
- ✅ **Environment Config** - Backend service URLs configured
- ✅ **Documentation** - Comprehensive guides created
- ⏳ **Frontend Views** - Still need UI updates for real data
- ⏳ **Error Pages** - Error handling views
- ⏳ **Styling** - CSS/styling for pages

---

## 📅 Version Information

- **Last Updated:** December 23, 2025
- **Version:** 1.0
- **Status:** Ready for Testing & Development
- **Tested With:** CodeIgniter 4, Laravel (Backend)

---

## 📝 License & Attribution

This integration documentation and implementation is part of the LibraryIS project.

---

## 🎯 Next Steps

1. **Backend Team:**
   - Complete GraphQL schema implementation
   - Set up RabbitMQ for async jobs
   - Populate test data in databases

2. **Frontend Team:**
   - Update views to display real API data
   - Implement member dashboard
   - Add error handling pages
   - Style authentication pages

3. **DevOps Team:**
   - Configure production environment
   - Set up CORS properly
   - Configure service discovery
   - Set up monitoring

4. **QA Team:**
   - Test all authentication flows
   - Test book operations
   - Test borrowing operations
   - Performance testing
   - Security testing

---

**For questions or issues, refer to the specific documentation files listed above.**
