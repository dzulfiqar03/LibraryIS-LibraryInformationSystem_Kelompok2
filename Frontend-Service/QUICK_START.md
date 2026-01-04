# LibraryIS Frontend - Quick Start Guide

## 🚀 5-Minute Setup

### Step 1: Install Dependencies
```bash
cd Frontend-Service/LibraryIS-app
composer install
```

### Step 2: Configure Environment
```bash
# Copy example environment file
cp .env.example .env

# Edit .env and set:
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
API_BASE_URL = 'http://localhost:3000/api'  # Your backend API URL
```

### Step 3: Start Development Server
```bash
php spark serve
```

Access the application at: `http://localhost:8080`

---

## 📖 What's Available

### Login Page
- **URL**: `http://localhost:8080/auth/login`
- **Features**: 
  - Email/password login
  - Remember me option
  - Show/hide password toggle
  - Responsive design

### Member Dashboard
- **URL**: `http://localhost:8080/member/dashboard`
- **Features**:
  - Quick statistics
  - Current borrowings
  - Recommendations carousel
  - Overdue books highlighting

### Book Search
- **URL**: `http://localhost:8080/member/books/search`
- **Features**:
  - Advanced search filters
  - Result pagination
  - Book availability status
  - Quick borrow/reserve buttons

---

## 🔧 Key Technologies

| Technology | Purpose |
|-----------|---------|
| **CodeIgniter 4** | PHP Framework |
| **Tailwind CSS** | Styling (via CDN) |
| **Alpine.js** | Lightweight interactivity |
| **PHP** | Backend logic |
| **Fetch API** | HTTP requests |

---

## 📂 Important Files

| File | Purpose |
|------|---------|
| `app/Config/Routes.php` | All application routes |
| `app/Views/layouts/member.php` | Main member portal layout |
| `resources/css/app.css` | Custom styles & components |
| `resources/js/app.js` | JavaScript utilities |
| `app/Services/ApiClient.php` | API communication |

---

## 🔄 API Integration

The frontend is ready to connect to your backend. You need to ensure your backend provides these endpoints:

### Authentication
```
POST   /api/auth/login          (email, password)
POST   /api/auth/register       (name, email, password)
GET    /api/auth/me             (get current user)
POST   /api/auth/logout
```

### Books
```
GET    /api/books/search?query=...&category=...&page=1
GET    /api/books/:id           (book details)
GET    /api/books/recommendations
```

### Borrowings
```
GET    /api/borrowings?page=1
POST   /api/borrowings          (borrow book)
POST   /api/borrowings/:id/return (return book)
GET    /api/fines               (user fines)
POST   /api/fines/:id/pay       (pay fine)
```

---

## 💡 Example: Using API Services

```php
<?php
// In your controller
use App\Services\BookService;

class BookController extends BaseController
{
    public function search()
    {
        $bookService = new BookService();
        
        // Search books with filters
        $results = $bookService->search(
            ['query' => 'Laravel', 'category' => 'programming'],
            1,  // page
            12  // per page
        );
        
        return view('books/search', ['books' => $results]);
    }
}
```

---

## 🎨 Customizing Styles

All custom styles are in `resources/css/app.css`. The file includes:

- **Button styles**: `.btn-primary`, `.btn-secondary`, `.btn-danger`
- **Card styles**: `.card`, `.card-hover`
- **Form styles**: `.input-field`, `.is-invalid`
- **Badge styles**: `.badge-success`, `.badge-warning`, `.badge-danger`

Example:
```html
<button class="btn btn-primary">Click Me</button>
<div class="card">Content here</div>
<input type="text" class="input-field">
```

---

## 📱 Testing on Mobile

```bash
# Find your machine IP
# Windows: ipconfig
# Mac/Linux: ifconfig

# Access from mobile
http://<your-ip>:8080
```

---

## 🐛 Troubleshooting

### "API not connecting"
✅ Check `API_BASE_URL` in `.env`
✅ Verify backend is running on correct port
✅ Check CORS headers in backend

### "Styles not loading"
✅ Tailwind CSS loads via CDN - check internet connection
✅ For production, compile CSS locally

### "404 on pages"
✅ Ensure routing is set up in `app/Config/Routes.php`
✅ Clear route cache: `php spark route:cache:clear`

### "Session not working"
✅ Check `session.savePath` in `.env` points to writable directory
✅ Ensure `storage/session` exists and is writable

---

## 📚 Learn More

- [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Alpine.js Docs](https://alpinejs.dev/)
- [Frontend Implementation Guide](./FRONTEND_IMPLEMENTATION.md)

---

## 🎯 Next Steps

1. **Configure API URL** in `.env` to point to your backend
2. **Test Login** - Verify authentication works
3. **Build Missing Pages** - Profile, borrowing history, etc.
4. **Style Customization** - Match your brand colors
5. **Performance** - Minify CSS/JS for production

---

**Happy coding! 🎉**
