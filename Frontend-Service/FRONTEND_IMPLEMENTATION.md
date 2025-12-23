# LibraryIS Frontend Implementation Guide

## 📋 Project Overview

This document covers the complete frontend implementation for the Digital Library Management System (LibraryIS) using CodeIgniter 4, Tailwind CSS, and Alpine.js.

## 🎯 What's Been Built

### 1. **Design System**
- ✅ Tailwind CSS configuration with custom color palette (Primary Blue, Secondary Purple, Status colors)
- ✅ Custom component styles (buttons, cards, badges, form inputs)
- ✅ Responsive spacing and typography system
- ✅ Animation utilities (fade-in, slide-up)

### 2. **Pages Created**

#### Authentication Pages
- **Login Page** (`app/Views/auth/login.php`)
  - Email and password fields with validation
  - Show/hide password toggle
  - Remember me checkbox
  - Forgot password link
  - Responsive design with gradient background

#### Member Portal Pages
- **Dashboard** (`app/Views/member/dashboard.php`)
  - Quick statistics (borrowed books, fines, reservations)
  - Current borrowings list with return buttons
  - Overdue book highlighting
  - Recommendations carousel
  - Responsive grid layout

- **Book Search** (`app/Views/member/books/search.php`)
  - Advanced search filters (category, year, language, availability)
  - Results grid with book cards
  - Pagination controls
  - Sort options (relevance, rating, newest, alphabetical)
  - Quick action buttons (Borrow, Reserve)
  - Responsive design (mobile-friendly)

### 3. **Layouts**
- **Base Layout** (`app/Views/layouts/base.php`)
  - Global HTML structure
  - Tailwind and font imports
  - Alpine.js integration
  - Head and scripts sections

- **Member Layout** (`app/Views/layouts/member.php`)
  - Responsive sidebar navigation
  - Mobile hamburger menu
  - Top bar with search and notifications
  - Profile dropdown menu
  - Navigation links with active states

### 4. **Controllers**
- **AuthController** - Login, register, logout, password reset
- **DashboardController** - Member dashboard
- **BookController** - Book search, detail, recommendations
- **BorrowingController** - Borrowing management (list, borrow, return)
- **ProfileController** - User profile and settings

### 5. **Services (API Integration)**
- **ApiClient** - HTTP client for backend API communication
- **AuthService** - Authentication operations
- **BookService** - Book-related operations
- **BorrowingService** - Borrowing and transaction operations

### 6. **JavaScript Utilities**
- **FormValidator** - Email, password, phone validation
- **ApiHelper** - GET, POST, PUT, DELETE requests with error handling
- **Toast** - Success/error notification system
- **DateHelper** - Date formatting and relative time
- **StringHelper** - Text utilities (truncate, slugify, currency)
- **Modal** - Modal dialog control

### 7. **Routing**
Complete route structure organized by:
- `auth/*` - Authentication routes
- `member/*` - Member portal routes
- `librarian/*` - Librarian dashboard routes (structure prepared)

## 📁 Project Structure

```
Frontend-Service/LibraryIS-app/
├── app/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   └── AuthController.php
│   │   ├── Member/
│   │   │   ├── DashboardController.php
│   │   │   ├── BookController.php
│   │   │   ├── BorrowingController.php
│   │   │   └── ProfileController.php
│   │   └── Librarian/ (prepared)
│   ├── Services/
│   │   ├── ApiClient.php
│   │   ├── AuthService.php
│   │   ├── BookService.php
│   │   └── BorrowingService.php
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── base.php
│   │   │   └── member.php
│   │   ├── auth/
│   │   │   └── login.php
│   │   └── member/
│   │       ├── dashboard.php
│   │       ├── books/
│   │       │   ├── search.php
│   │       │   └── detail.php
│   │       ├── borrowings/
│   │       ├── profile/
│   │       └── settings/
│   └── Config/
│       └── Routes.php
└── resources/
    ├── css/
    │   └── app.css
    ├── js/
    │   └── app.js
    └── views/ (Blade templates)
```

## 🚀 Getting Started

### 1. Environment Setup
```bash
# Install Composer dependencies
composer install

# Copy environment file
cp .env.example .env

# Set API base URL in .env
API_BASE_URL=http://localhost:3000/api
```

### 2. Configure Tailwind CSS
The project uses Tailwind CSS via CDN for development. For production, you should:

```bash
# Install Tailwind CSS locally
npm install -D tailwindcss postcss autoprefixer

# Generate CSS
npm run build
```

### 3. Start Development Server
```bash
# Using PHP built-in server
php spark serve

# Access application
http://localhost:8080
```

### 4. Routes Available

**Authentication:**
- `GET /auth/login` - Login page
- `POST /auth/login` - Process login
- `GET /auth/register` - Registration page
- `POST /auth/register` - Process registration
- `GET /auth/logout` - Logout

**Member Portal:**
- `GET /member/dashboard` - Dashboard
- `GET /member/books/search` - Search books
- `GET /member/borrowings` - Borrowing list
- `GET /member/profile` - User profile

## 🔌 API Integration

### Using Services
```php
// In your controller
use App\Services\BookService;

$bookService = new BookService();
$books = $bookService->search(['query' => 'Laravel'], 1, 12);
```

### API Endpoints Expected

The frontend expects these endpoints from your backend:

**Authentication:**
```
POST   /api/auth/login
POST   /api/auth/register
POST   /api/auth/logout
GET    /api/auth/me
PUT    /api/auth/profile
POST   /api/auth/change-password
POST   /api/auth/forgot-password
POST   /api/auth/reset-password
```

**Books:**
```
GET    /api/books/search
GET    /api/books/:id
GET    /api/books/recommendations
GET    /api/books/featured
POST   /api/books (Librarian)
PUT    /api/books/:id (Librarian)
DELETE /api/books/:id (Librarian)
```

**Borrowings:**
```
GET    /api/borrowings
GET    /api/borrowings/:id
POST   /api/borrowings (borrow)
POST   /api/borrowings/:id/return
GET    /api/borrowings/overdue (Librarian)
POST   /api/borrowings/:id/process-return (Librarian)
```

**Fines & Reservations:**
```
GET    /api/fines
POST   /api/fines/:id/pay
POST   /api/reservations
DELETE /api/reservations/:id
```

## 🎨 Design Features

### Color Palette
- **Primary Blue**: `#2563eb` - Main brand color
- **Secondary Purple**: `#7c3aed` - Secondary actions
- **Success Green**: `#10b981` - Available books
- **Warning Amber**: `#f59e0b` - Expiring items
- **Danger Red**: `#ef4444` - Overdue, fines

### Typography
- **Display Font**: Poppins (headings)
- **Body Font**: Inter (content)
- **Monospace**: Fira Code (IDs, technical info)

### Responsive Breakpoints
- Mobile: `< 640px`
- Tablet: `640px - 1024px`
- Desktop: `> 1024px`

## ✨ Key Features

### Login Page
- Real-time password strength indicator
- Show/hide password toggle
- Remember me functionality
- Responsive gradient background
- Error message display

### Member Dashboard
- Overdue book highlighting
- Quick action buttons
- Current borrowing summary
- Recommendation carousel
- Statistics cards with icons

### Book Search
- Advanced filtering (category, year, language)
- Full-text search
- Result sorting
- Book availability badges
- Quick borrow/reserve buttons
- Pagination

### Responsive Design
- Mobile-first approach
- Hamburger menu for mobile navigation
- Card-based layouts for mobile
- Touch-friendly button sizes
- Optimized images and icons

## 🔐 Security Features

- CSRF token validation (CodeIgniter built-in)
- Password hashing with bcrypt
- Session management
- API token handling (JWT ready)
- Input validation
- XSS protection

## 📱 Mobile Optimization

- Responsive grid layouts
- Touch-friendly buttons (min 44px)
- Optimized images
- Mobile navigation (hamburger menu)
- Finger-friendly form inputs
- Readable text sizes

## 🔄 Next Steps

### Immediate Tasks
1. **Connect to Backend API**
   - Update `API_BASE_URL` in `.env`
   - Test API connections
   - Implement error handling

2. **Complete Missing Pages**
   - Register page (`auth/register.php`)
   - Book detail page (`member/books/detail.php`)
   - Borrowing list page (`member/borrowings/index.php`)
   - Profile pages (`member/profile/index.php`)
   - Settings page (`member/settings.php`)

3. **Build Librarian Portal**
   - Dashboard (`librarian/dashboard.php`)
   - Member management pages
   - Book management pages
   - Transaction management
   - Reports and analytics

### Testing
```bash
# Run tests
php spark test

# Check code quality
php spark lint
```

### Deployment
1. Set `CI_ENVIRONMENT=production` in `.env`
2. Compile Tailwind CSS
3. Optimize routes with caching
4. Set up proper error logging
5. Configure HTTPS

## 📚 Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Alpine.js Docs](https://alpinejs.dev/)
- [REST API Best Practices](https://restfulapi.net/)

## 💡 Development Tips

### Using Alpine.js for Interactivity
```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <div x-show="open">Content</div>
</div>
```

### Using JavaScript Helpers
```javascript
// Validation
FormValidator.validateEmail('user@example.com');

// API Calls
ApiHelper.get('/api/books').then(data => console.log(data));

// Toast Notifications
Toast.success('Operation completed!');

// Date Formatting
DateHelper.format(new Date(), 'MM/DD/YYYY');
```

### Adding New Pages
1. Create view file in `app/Views/`
2. Create controller in `app/Controllers/`
3. Add routes in `app/Config/Routes.php`
4. Use services for API calls

## 📞 Support & Troubleshooting

**Issue: Tailwind CSS not loading**
- Solution: Check if CDN is accessible or compile locally

**Issue: API calls failing**
- Solution: Verify `API_BASE_URL` in `.env` and CORS settings

**Issue: Session not persisting**
- Solution: Check PHP session configuration in `.env`

**Issue: Images not loading**
- Solution: Verify public path and symlink if needed

## 📄 License

This project is part of the LibraryIS Digital Library Management System.

---

**Last Updated**: December 15, 2025
**Version**: 1.0.0
