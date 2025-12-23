# LibraryIS Frontend - Component & Utility Usage Guide

## 🎯 Overview

This guide shows how to use the built-in components, services, and utilities in your pages.

---

## 🧩 Components & Styling

### Buttons

```html
<!-- Primary Button -->
<button class="btn btn-primary">Save Changes</button>

<!-- Secondary Button -->
<button class="btn btn-secondary">Cancel</button>

<!-- Danger Button -->
<button class="btn btn-danger">Delete</button>

<!-- Success Button -->
<button class="btn btn-success">Confirm</button>

<!-- Outline Button -->
<button class="btn btn-outline">Learn More</button>

<!-- Small Button -->
<button class="btn btn-sm btn-primary">Save</button>

<!-- Large Button -->
<button class="btn btn-lg btn-primary">Save</button>

<!-- With Icon -->
<button class="btn btn-primary">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
  </svg>
  <span>Add New</span>
</button>
```

### Cards

```html
<!-- Basic Card -->
<div class="card">
  <h3 class="font-display font-bold text-gray-900">Card Title</h3>
  <p class="text-gray-600 mt-2">Card content goes here</p>
</div>

<!-- Hover Card -->
<div class="card-hover">
  <h3 class="font-display font-bold">Interactive Card</h3>
  <p>This card has hover effects</p>
</div>

<!-- Card with Sections -->
<div class="card">
  <div class="flex items-center justify-between mb-6">
    <h3 class="font-display font-bold text-gray-900">Books Available</h3>
    <a href="#" class="text-primary-600 hover:text-primary-700">View All →</a>
  </div>
  <!-- Content -->
</div>
```

### Badges

```html
<!-- Success Badge -->
<span class="badge badge-success">Available</span>

<!-- Danger Badge -->
<span class="badge badge-danger">Overdue</span>

<!-- Warning Badge -->
<span class="badge badge-warning">Reserved</span>

<!-- Primary Badge -->
<span class="badge badge-primary">Featured</span>

<!-- Secondary Badge -->
<span class="badge badge-secondary">New</span>
```

### Form Inputs

```html
<!-- Text Input -->
<input type="text" class="input-field" placeholder="Enter text">

<!-- With Label -->
<label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
<input type="email" class="input-field" placeholder="your@email.com">

<!-- Text Area -->
<textarea class="input-field" rows="5" placeholder="Write something..."></textarea>

<!-- Select Dropdown -->
<select class="input-field">
  <option>Select an option</option>
  <option>Option 1</option>
  <option>Option 2</option>
</select>

<!-- With Error State -->
<input type="text" class="input-field is-invalid">
<p class="error-text">This field is required</p>

<!-- With Success State -->
<input type="text" class="input-field">
<p class="success-text">Email verified successfully</p>

<!-- Checkbox -->
<label class="flex items-center gap-2 text-sm">
  <input type="checkbox" class="rounded">
  <span>Remember me</span>
</label>

<!-- Radio -->
<label class="flex items-center gap-2 text-sm">
  <input type="radio" name="option" class="rounded-full">
  <span>Option 1</span>
</label>
```

### Alerts & Notifications

```html
<!-- Success Alert -->
<div class="mb-4 p-4 bg-success-50 border border-success-200 rounded-lg flex gap-3">
  <svg class="w-5 h-5 text-success-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
  </svg>
  <div>
    <p class="font-medium text-success-800">Success</p>
    <p class="text-sm text-success-700">Operation completed successfully</p>
  </div>
</div>

<!-- Error Alert -->
<div class="mb-4 p-4 bg-danger-50 border border-danger-200 rounded-lg flex gap-3">
  <svg class="w-5 h-5 text-danger-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
  </svg>
  <div>
    <p class="font-medium text-danger-800">Error</p>
    <p class="text-sm text-danger-700">Something went wrong</p>
  </div>
</div>
```

### Tables

```html
<!-- Basic Table -->
<div class="overflow-x-auto">
  <table class="w-full">
    <thead class="bg-gray-50 border-b border-gray-200">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Book Title</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Author</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 text-sm text-gray-900">The Great Gatsby</td>
        <td class="px-6 py-4 text-sm text-gray-600">F. Scott Fitzgerald</td>
        <td class="px-6 py-4 text-sm">
          <span class="badge badge-success">Available</span>
        </td>
        <td class="px-6 py-4 text-sm">
          <button class="text-primary-600 hover:text-primary-700">View</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
```

---

## 📡 API Services

### Using BookService

```php
<?php
use App\Services\BookService;

$bookService = new BookService();

// Search books
$results = $bookService->search(
    ['query' => 'Laravel', 'category' => 'programming'],
    1,  // page
    12  // per page
);

// Get book details
$book = $bookService->getDetail(123);

// Get recommendations
$recommended = $bookService->getRecommendations(20);

// Get featured books
$featured = $bookService->getFeatured(10);
```

### Using BorrowingService

```php
<?php
use App\Services\BorrowingService;

$borrowingService = new BorrowingService();

// Get user borrowings
$borrowings = $borrowingService->getBorrowings(1, 10);

// Borrow a book
$result = $borrowingService->borrow(123);

// Return a book
$result = $borrowingService->return(456);

// Reserve a book
$result = $borrowingService->reserve(123);

// Get user fines
$fines = $borrowingService->getFines();

// Pay a fine
$result = $borrowingService->payFine(789, 5.00);
```

### Using AuthService

```php
<?php
use App\Services\AuthService;

$authService = new AuthService();

// Login
$user = $authService->login('user@example.com', 'password');
// Returns: ['user' => {...}, 'token' => 'jwt-token']

// Get current user
$user = $authService->getCurrentUser();

// Update profile
$result = $authService->updateProfile([
    'name' => 'New Name',
    'email' => 'newemail@example.com'
]);

// Change password
$result = $authService->changePassword('oldpass', 'newpass');
```

---

## 🎯 JavaScript Utilities

### Form Validation

```javascript
// Validate email
if (FormValidator.validateEmail('user@example.com')) {
  console.log('Valid email');
}

// Validate password
const pwd = FormValidator.validatePassword('SecurePass123!');
console.log(pwd.strength);  // 'strong', 'medium', 'weak'
console.log(pwd.requirements);  // { minLength: true, hasUpperCase: true, ... }

// Validate required field
if (FormValidator.validateRequired(inputValue)) {
  console.log('Field is required');
}

// Validate min length
if (FormValidator.validateMinLength(password, 8)) {
  console.log('Password is at least 8 characters');
}

// Validate phone
if (FormValidator.validatePhone('+1 (555) 123-4567')) {
  console.log('Valid phone number');
}

// Validate URL
if (FormValidator.validateUrl('https://example.com')) {
  console.log('Valid URL');
}
```

### API Helper

```javascript
// GET request
ApiHelper.get('/api/books', { page: 1, limit: 10 })
  .then(response => console.log(response))
  .catch(error => console.error(error));

// POST request
ApiHelper.post('/api/borrowings', { book_id: 123 })
  .then(response => Toast.success('Book borrowed!'))
  .catch(error => Toast.error(error.message));

// PUT request
ApiHelper.put('/api/books/123', { title: 'New Title' })
  .then(response => console.log('Updated'));

// DELETE request
ApiHelper.delete('/api/books/123')
  .then(response => Toast.success('Deleted!'));
```

### Toast Notifications

```javascript
// Success notification
Toast.success('Operation completed successfully!');

// Error notification (5 second duration)
Toast.error('An error occurred', 5000);

// Warning notification
Toast.warning('Please be careful with this action', 4000);

// Info notification
Toast.info('This is an informational message', 3000);

// Custom notification
Toast.show('Custom message', 'success', 3000);
```

### Date Helper

```javascript
// Format date
DateHelper.format(new Date(), 'MM/DD/YYYY');  // "12/15/2025"
DateHelper.format(new Date(), 'MM/DD/YYYY HH:mm');  // "12/15/2025 14:30"

// Relative time
DateHelper.relative(new Date(Date.now() - 3600000));  // "1 hour ago"

// Days until
const daysLeft = DateHelper.daysUntil('2025-12-31');
console.log(`${daysLeft} days until due`);
```

### String Helper

```javascript
// Truncate text
StringHelper.truncate('Long text here...', 50);  // "Long text here..."

// Capitalize
StringHelper.capitalize('hello');  // "Hello"

// Slugify
StringHelper.slugify('Hello World');  // "hello-world"

// Format currency
StringHelper.formatCurrency(1234.56, 'USD');  // "$1,234.56"
StringHelper.formatCurrency(1234.56, 'EUR');  // "€1,234.56"

// Format number
StringHelper.formatNumber(1000000, 2);  // "1,000,000.00"
```

### Modal Helper

```javascript
// Open modal
Modal.open('confirmModal');

// Close specific modal
Modal.close('confirmModal');

// Close all modals
Modal.closeAll();
```

---

## 🔄 Alpine.js Interactive Components

### Toggle Component

```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <div x-show="open" class="mt-4">
    This content is shown when open is true
  </div>
</div>
```

### Dropdown Menu

```html
<div x-data="{ open: false }" class="relative">
  <button @click="open = !open">Menu</button>
  
  <div 
    x-show="open"
    @click.outside="open = false"
    class="absolute right-0 mt-2 bg-white rounded shadow-lg"
  >
    <a href="#" class="block px-4 py-2">Option 1</a>
    <a href="#" class="block px-4 py-2">Option 2</a>
  </div>
</div>
```

### Form with Validation

```html
<div x-data="{ email: '', submitted: false }">
  <form @submit="submitted = true">
    <input 
      type="email" 
      x-model="email" 
      class="input-field"
      :class="{ 'is-invalid': submitted && !FormValidator.validateEmail(email) }"
    >
    <p x-show="submitted && !FormValidator.validateEmail(email)" class="error-text">
      Please enter a valid email
    </p>
    <button type="submit" class="btn btn-primary mt-4">Submit</button>
  </form>
</div>
```

### Tab Component

```html
<div x-data="{ activeTab: 'tab1' }">
  <div class="flex gap-2 border-b">
    <button 
      @click="activeTab = 'tab1'"
      :class="{ 'border-b-2 border-primary-600': activeTab === 'tab1' }"
    >
      Tab 1
    </button>
    <button 
      @click="activeTab = 'tab2'"
      :class="{ 'border-b-2 border-primary-600': activeTab === 'tab2' }"
    >
      Tab 2
    </button>
  </div>
  
  <div x-show="activeTab === 'tab1'" class="mt-4">Content for tab 1</div>
  <div x-show="activeTab === 'tab2'" class="mt-4">Content for tab 2</div>
</div>
```

---

## 📋 Complete Example: Book Borrowing Page

```php
<?= $this->extend('layouts/member') ?>

<?= $this->section('page_content') ?>
<div x-data="borrowPage()">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-display font-bold">Borrow a Book</h1>
  </div>

  <!-- Search -->
  <div class="card mb-8">
    <input 
      type="text" 
      x-model="search"
      @keyup="searchBooks()"
      placeholder="Search books..."
      class="input-field w-full"
    >
  </div>

  <!-- Results -->
  <template x-if="books.length">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <template x-for="book in books" :key="book.id">
        <div class="card">
          <h3 x-text="book.title" class="font-bold"></h3>
          <p x-text="book.author" class="text-gray-600 text-sm"></p>
          
          <button 
            @click="borrow(book.id)"
            :disabled="book.status !== 'available'"
            class="btn btn-primary w-full mt-4"
          >
            <span x-show="book.status === 'available'">Borrow</span>
            <span x-show="book.status !== 'available'" x-text="book.status"></span>
          </button>
        </div>
      </template>
    </div>
  </template>

  <!-- Empty State -->
  <template x-if="!books.length && searched">
    <div class="text-center py-12">
      <p class="text-gray-500">No books found</p>
    </div>
  </template>
</div>

<script>
function borrowPage() {
  return {
    search: '',
    books: [],
    searched: false,

    async searchBooks() {
      if (!this.search.trim()) {
        this.books = [];
        return;
      }

      try {
        const response = await ApiHelper.get('/api/books/search', {
          query: this.search
        });
        this.books = response.data || [];
        this.searched = true;
      } catch (error) {
        Toast.error('Search failed');
      }
    },

    async borrow(bookId) {
      try {
        await ApiHelper.post('/api/borrowings', { book_id: bookId });
        Toast.success('Book borrowed successfully!');
        window.location.href = '/member/borrowings';
      } catch (error) {
        Toast.error(error.message);
      }
    }
  }
}
</script>
<?= $this->endSection() ?>
```

---

## 🎨 Color Reference

```html
<!-- Primary Colors -->
<div class="bg-primary-600 text-primary-600">Primary</div>

<!-- Secondary Colors -->
<div class="bg-secondary-600 text-secondary-600">Secondary</div>

<!-- Status Colors -->
<div class="bg-success-600 text-success-600">Success</div>
<div class="bg-warning-600 text-warning-600">Warning</div>
<div class="bg-danger-600 text-danger-600">Danger</div>

<!-- Neutral Colors -->
<div class="bg-gray-50">Light gray</div>
<div class="bg-gray-500">Medium gray</div>
<div class="bg-gray-900">Dark gray</div>
```

---

**Happy Building! 🚀**
