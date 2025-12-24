<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Search Books<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="searchBooks()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">Search Books</h1>
        <p class="text-gray-600 mt-1">Find your next great read</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <form @submit.prevent="searchBooks()" class="space-y-4">
                <!-- Main Search Input -->
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input 
                        type="text" 
                        x-model="query.search"
                        placeholder="Search by title, author, or ISBN..." 
                        class="input-field w-full pl-12 text-lg"
                    >
                </div>

                <!-- Advanced Search Toggle & Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                        <select x-model="query.category" class="input-field w-full">
                            <option value="">All Categories</option>
                            <option value="fiction">Fiction</option>
                            <option value="non-fiction">Non-Fiction</option>
                            <option value="mystery">Mystery</option>
                            <option value="science-fiction">Science Fiction</option>
                            <option value="biography">Biography</option>
                            <option value="history">History</option>
                            <option value="romance">Romance</option>
                            <option value="children">Children's</option>
                        </select>
                    </div>

                    <!-- Publication Year -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Published Year</label>
                        <div class="flex gap-2">
                            <input 
                                type="number" 
                                x-model="query.yearFrom" 
                                placeholder="From" 
                                class="input-field flex-1"
                                min="1800"
                                max="2099"
                            >
                            <input 
                                type="number" 
                                x-model="query.yearTo" 
                                placeholder="To" 
                                class="input-field flex-1"
                                min="1800"
                                max="2099"
                            >
                        </div>
                    </div>

                    <!-- Language -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Language</label>
                        <select x-model="query.language" class="input-field w-full">
                            <option value="">All Languages</option>
                            <option value="en">English</option>
                            <option value="id">Indonesian</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                            <option value="de">German</option>
                            <option value="ja">Japanese</option>
                            <option value="zh">Chinese</option>
                        </select>
                    </div>

                    <!-- Availability -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Availability</label>
                        <select x-model="query.availability" class="input-field w-full">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                            <option value="reserved">Can Reserve</option>
                        </select>
                    </div>
                </div>

                <!-- Search Buttons -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Search</span>
                    </button>
                    <button type="button" @click="resetFilters()" class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Filters (Desktop) -->
        <div class="hidden lg:block">
            <div class="card sticky top-24">
                <h3 class="font-display font-bold text-gray-900 mb-4">Refine Results</h3>
                
                <!-- Filter Groups -->
                <div class="space-y-6">
                    <!-- Ratings -->
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm mb-3">Ratings</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.rating" value="5" class="rounded">
                                <span>★★★★★ 5 stars</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.rating" value="4" class="rounded">
                                <span>★★★★☆ 4+ stars</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.rating" value="3" class="rounded">
                                <span>★★★☆☆ 3+ stars</span>
                            </label>
                        </div>
                    </div>

                    <!-- Book Format -->
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm mb-3">Format</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.format" value="hardcover" class="rounded">
                                <span>Hardcover</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.format" value="paperback" class="rounded">
                                <span>Paperback</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-model="query.format" value="ebook" class="rounded">
                                <span>E-book</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm mb-3">Price Range</h4>
                        <input type="range" x-model="query.maxPrice" min="0" max="100" class="w-full">
                        <p class="text-sm text-gray-600 mt-2">Up to $<span x-text="query.maxPrice"></span></p>
                    </div>
                </div>

                <button @click="applyFilters()" class="btn btn-primary w-full mt-6">Apply Filters</button>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3">
            <!-- Results Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-gray-600">
                        Showing <span class="font-semibold">1-12</span> of <span class="font-semibold">245</span> results
                    </p>
                </div>
                <div class="flex gap-2">
                    <select x-model="sortBy" class="input-field text-sm">
                        <option value="relevance">Most Relevant</option>
                        <option value="rating">Highest Rated</option>
                        <option value="newest">Newest</option>
                        <option value="title">Title A-Z</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Book Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <!-- Book Card 1 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-success opacity-0 group-hover:opacity-100 transition-opacity">Available</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">Atomic Habits</h3>
                        <p class="text-xs text-gray-600 mt-1">James Clear</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.8 (5.2k)</span>
                        </div>
                        <button @click="borrowBook(1)" class="btn btn-sm btn-primary w-full mt-3">Borrow</button>
                    </div>
                </div>

                <!-- Book Card 2 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-warning opacity-0 group-hover:opacity-100 transition-opacity">Reserved</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">Thinking, Fast and Slow</h3>
                        <p class="text-xs text-gray-600 mt-1">Daniel Kahneman</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.5 (3.1k)</span>
                        </div>
                        <button @click="reserveBook(2)" class="btn btn-sm btn-outline w-full mt-3">Reserve</button>
                    </div>
                </div>

                <!-- Book Card 3 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-danger opacity-0 group-hover:opacity-100 transition-opacity">Unavailable</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">Deep Work</h3>
                        <p class="text-xs text-gray-600 mt-1">Cal Newport</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.6 (2.8k)</span>
                        </div>
                        <button class="btn btn-sm btn-secondary w-full mt-3 opacity-50 cursor-not-allowed">Unavailable</button>
                    </div>
                </div>

                <!-- Book Card 4 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-success opacity-0 group-hover:opacity-100 transition-opacity">Available</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">The Lean Startup</h3>
                        <p class="text-xs text-gray-600 mt-1">Eric Ries</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.3 (4.2k)</span>
                        </div>
                        <button @click="borrowBook(4)" class="btn btn-sm btn-primary w-full mt-3">Borrow</button>
                    </div>
                </div>

                <!-- Book Card 5 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-success opacity-0 group-hover:opacity-100 transition-opacity">Available</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">Outliers</h3>
                        <p class="text-xs text-gray-600 mt-1">Malcolm Gladwell</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.4 (3.7k)</span>
                        </div>
                        <button @click="borrowBook(5)" class="btn btn-sm btn-primary w-full mt-3">Borrow</button>
                    </div>
                </div>

                <!-- Book Card 6 -->
                <div class="group cursor-pointer">
                    <div class="relative bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 overflow-hidden group-hover:shadow-lg transition-all">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <div class="absolute top-2 right-2 badge badge-success opacity-0 group-hover:opacity-100 transition-opacity">Available</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-2">The 7 Habits</h3>
                        <p class="text-xs text-gray-600 mt-1">Stephen Covey</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600">4.7 (5.8k)</span>
                        </div>
                        <button @click="borrowBook(6)" class="btn btn-sm btn-primary w-full mt-3">Borrow</button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center gap-2">
                <button class="btn btn-outline">← Previous</button>
                <button class="btn bg-primary-600 text-white">1</button>
                <button class="btn btn-outline">2</button>
                <button class="btn btn-outline">3</button>
                <span class="text-gray-500">...</span>
                <button class="btn btn-outline">20</button>
                <button class="btn btn-outline">Next →</button>
            </div>
        </div>
    </div>
</div>

<script>
function searchBooks() {
    return {
        query: {
            search: '',
            category: '',
            language: '',
            page: 1
        },
        results: [],
        pagination: { current_page: 1, total_pages: 1 },
        loading: false,

        init() {
            this.loadBooks();  // Load books on page load
        },

        async loadBooks() {
            this.loading = true;
            this.results = [];

            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
                const headers = {
                    'Content-Type': 'application/json'
                };
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                let url = '<?= site_url('api/books/') ?>';
                let options = {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                };

                // If there's any search input, use POST /search
                if (this.query.search || this.query.category || this.query.language) {
                    url = '<?= site_url('api/books/search') ?>';
                    options.method = 'POST';
                    options.body = JSON.stringify({
                        search: this.query.search,
                        category: this.query.category,
                        language: this.query.language,
                        page: this.query.page
                    });
                } else {
                    // Add page param for GET
                    url += '?page=' + this.query.page;
                }

                const response = await fetch(url, options);

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`HTTP ${response.status}: ${response.statusText} - ${errorText}`);
                }

                const data = await response.json();

                this.results = data.books || data.data || [];
                this.pagination = data.pagination || { current_page: 1, total_pages: 1 };

            } catch (error) {
                console.error('Search/load error:', error);
                alert('Search failed: ' + error.message);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        // Pagination
        prevPage() {
            if (this.query.page > 1) {
                this.query.page--;
                this.loadBooks();
            }
        },
        nextPage() {
            if (this.query.page < this.pagination.total_pages) {
                this.query.page++;
                this.loadBooks();
            }
        },

        async borrowBook(bookId) {
            if (!confirm('Borrow this book?')) return;

            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
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
                    this.loadBooks();
                } else {
                    alert(data.message || 'Failed to borrow book');
                }
            } catch (error) {
                console.error('Borrow error:', error);
                alert('Error borrowing book');
            }
        },

        async reserveBook(bookId) {
            if (!confirm('Reserve this book?')) return;

            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
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
                    this.loadBooks();
                } else {
                    alert(data.message || 'Failed to reserve book');
                }
            } catch (error) {
                console.error('Reserve error:', error);
                alert('Error reserving book');
            }
        }
    }
}
</script>
<?= $this->endSection() ?>
