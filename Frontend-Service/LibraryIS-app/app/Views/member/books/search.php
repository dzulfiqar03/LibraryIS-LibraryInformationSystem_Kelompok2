<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Search Books<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="bookSearch()" x-init="loadBooks()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">Search Books</h1>
        <p class="text-gray-600 mt-1">Find your next great read from our collection</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <form @submit.prevent="searchBooks()" class="space-y-4">
                <!-- Main Search Input -->
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search by title, author, or keyword..." 
                        class="input-field w-full pl-12 pr-4 py-3 rounded-lg"
                    >
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select x-model="selectedCategory" @change="searchBooks()" class="input-field w-full">
                            <option value="">All Categories</option>
                            <option value="fiction">Fiction</option>
                            <option value="non-fiction">Non-Fiction</option>
                            <option value="mystery">Mystery</option>
                            <option value="science">Science</option>
                            <option value="history">History</option>
                            <option value="biography">Biography</option>
                        </select>
                    </div>
                    
                    <!-- Availability Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Availability</label>
                        <select x-model="availabilityFilter" @change="searchBooks()" class="input-field w-full">
                            <option value="">All Books</option>
                            <option value="available">Available Only</option>
                            <option value="borrowed">Currently Borrowed</option>
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sort By</label>
                        <select x-model="sortBy" @change="searchBooks()" class="input-field w-full">
                            <option value="title">Title</option>
                            <option value="author">Author</option>
                            <option value="year">Publication Year</option>
                            <option value="popularity">Popularity</option>
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="pt-2">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Search Books</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Searching...
                        </span>
                    </button>
                    <button type="button" @click="clearFilters()" class="btn btn-outline ml-2">
                        Clear Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="space-y-6">
        <!-- Loading State -->
        <div x-show="loading" class="text-center py-12">
            <svg class="animate-spin mx-auto w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600 mt-2">Loading books...</p>
        </div>

        <!-- Error State -->
        <div x-show="error && !loading" class="text-center py-12">
            <div class="text-red-600 mb-4">
                <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2"></path>
                </svg>
            </div>
            <p class="text-gray-600" x-text="error"></p>
            <button @click="loadBooks()" class="btn btn-primary mt-4">Try Again</button>
        </div>

        <!-- Books Grid -->
        <div x-show="!loading && !error && books.length > 0">
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">
                    Showing <span x-text="books.length"></span> books
                    <span x-show="searchQuery" x-text="'for \"' + searchQuery + '\"'"></span>
                </p>
            </div>

            <!-- Book Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <template x-for="book in books" :key="book.id">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer" @click="viewBook(book.id)">
                        <!-- Book Cover -->
                        <div class="aspect-[3/4] bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center relative">
                            <template x-if="book.url_cover">
                                <img :src="book.url_cover" :alt="book.title" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!book.url_cover">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                </svg>
                            </template>
                            
                            <!-- Availability Badge -->
                            <div class="absolute top-2 right-2">
                                <span x-show="book.quantity > 0" class="badge badge-success">Available</span>
                                <span x-show="book.quantity <= 0" class="badge badge-danger">Not Available</span>
                            </div>
                        </div>
                        
                        <!-- Book Info -->
                        <div class="p-4">
                            <h3 class="font-display font-bold text-gray-900 text-sm mb-1" x-text="book.title"></h3>
                            <p class="text-gray-600 text-xs mb-2" x-text="book.author"></p>
                            
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-2">
                                    <template x-if="book.quantity > 0">
                                        <button @click.stop="borrowBook(book.id)" class="btn btn-primary text-xs">
                                            Borrow
                                        </button>
                                    </template>
                                    <template x-if="book.quantity <= 0">
                                        <button @click.stop="reserveBook(book.id)" class="btn btn-outline text-xs">
                                            Reserve
                                        </button>
                                    </template>
                                </div>
                                <span class="text-xs text-gray-500" x-text="book.category"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Pagination -->
            <div x-show="totalPages > 1" class="flex justify-center mt-8 gap-2">
                <button @click="previousPage()" :disabled="currentPage <= 1" class="btn btn-outline" :class="{ 'opacity-50 cursor-not-allowed': currentPage <= 1 }">
                    Previous
                </button>
                
                <template x-for="page in pageNumbers" :key="page">
                    <button @click="goToPage(page)" :class="page === currentPage ? 'btn btn-primary' : 'btn btn-outline'" x-text="page"></button>
                </template>
                
                <button @click="nextPage()" :disabled="currentPage >= totalPages" class="btn btn-outline" :class="{ 'opacity-50 cursor-not-allowed': currentPage >= totalPages }">
                    Next
                </button>
            </div>
        </div>

        <!-- No Results -->
        <div x-show="!loading && !error && books.length === 0" class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <p class="text-gray-600 text-lg mb-2">No books found</p>
            <p class="text-gray-500">Try adjusting your search criteria</p>
            <button @click="clearFilters()" class="btn btn-primary mt-4">Clear All Filters</button>
        </div>
    </div>
</div>

<script>
function bookSearch() {
    return {
        // Data
        books: [],
        loading: false,
        error: null,
        
        // Search parameters
        searchQuery: '',
        selectedCategory: '',
        availabilityFilter: '',
        sortBy: 'title',
        
        // Pagination
        currentPage: 1,
        totalPages: 1,
        perPage: 12,
        
        // Computed properties
        get pageNumbers() {
            let pages = [];
            let start = Math.max(1, this.currentPage - 2);
            let end = Math.min(this.totalPages, this.currentPage + 2);
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },

        // Methods
        async loadBooks() {
            this.loading = true;
            this.error = null;

            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                let url = '<?= site_url('api/books') ?>';
                let params = new URLSearchParams({
                    page: this.currentPage,
                    per_page: this.perPage
                });

                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.selectedCategory) params.append('category', this.selectedCategory);
                if (this.availabilityFilter) params.append('availability', this.availabilityFilter);
                if (this.sortBy) params.append('sort', this.sortBy);

                const response = await fetch(`${url}?${params}`, {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();
                
                if (data.success === false) {
                    throw new Error(data.message || 'Failed to load books');
                }

                this.books = data.books || data.data || [];
                this.totalPages = data.pagination?.total_pages || 1;
                
            } catch (error) {
                console.error('Load books error:', error);
                this.error = error.message;
                this.books = [];
            } finally {
                this.loading = false;
            }
        },

        searchBooks() {
            this.currentPage = 1;
            this.loadBooks();
        },

        clearFilters() {
            this.searchQuery = '';
            this.selectedCategory = '';
            this.availabilityFilter = '';
            this.sortBy = 'title';
            this.currentPage = 1;
            this.loadBooks();
        },

        // Pagination methods
        goToPage(page) {
            this.currentPage = page;
            this.loadBooks();
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.loadBooks();
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadBooks();
            }
        },

        // Book actions
        viewBook(bookId) {
            window.location.href = `<?= site_url('member/books/detail') ?>/${bookId}`;
        },

        async borrowBook(bookId) {
            if (!confirm('Do you want to borrow this book?')) return;

            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const headers = {
                    'Content-Type': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/borrowings/borrow') ?>', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ book_id: bookId }),
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success) {
                    alert('Book borrowed successfully!');
                    this.loadBooks(); // Refresh the list
                } else {
                    alert(data.message || 'Failed to borrow book');
                }
            } catch (error) {
                console.error('Borrow error:', error);
                alert('Error borrowing book: ' + error.message);
            }
        },

        async reserveBook(bookId) {
            if (!confirm('Do you want to reserve this book?')) return;

            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const headers = {
                    'Content-Type': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/borrowings/reserve') ?>', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ book_id: bookId }),
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success) {
                    alert('Book reserved successfully!');
                    this.loadBooks(); // Refresh the list
                } else {
                    alert(data.message || 'Failed to reserve book');
                }
            } catch (error) {
                console.error('Reserve error:', error);
                alert('Error reserving book: ' + error.message);
            }
        }
    }
}
</script>
<?= $this->endSection() ?>