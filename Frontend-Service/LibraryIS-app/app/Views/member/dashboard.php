<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="memberDashboard()" x-init="loadDashboardData()">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">Welcome, <?= esc(session('user_name')) ?>!</h1>
        <p class="text-gray-600 mt-1">Here's your library activity overview</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Borrowings -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Borrowings</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.active_borrowings">-</p>
                </div>
                <div class="bg-primary-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Overdue Books -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Overdue Books</p>
                    <p class="text-2xl font-bold" :class="stats.overdue_books > 0 ? 'text-red-600' : 'text-gray-900'" x-text="stats.overdue_books">-</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Books Read -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Books Read</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.total_read">-</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Current Borrowings - 2/3 width -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-display font-bold text-gray-900">Current Borrowings</h2>
                    <a href="<?= site_url('member/borrowings') ?>" class="btn btn-outline text-sm">View All</a>
                </div>

                <!-- Loading State -->
                <div x-show="loading.borrowings" class="text-center py-8">
                    <svg class="animate-spin mx-auto w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600 text-sm mt-2">Loading borrowings...</p>
                </div>

                <!-- Empty State -->
                <div x-show="!loading.borrowings && borrowings.length === 0" class="text-center py-8">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-2">No active borrowings</p>
                    <p class="text-gray-500 text-sm">Start by borrowing some books!</p>
                    <a href="<?= site_url('member/books/search') ?>" class="btn btn-primary mt-4">Browse Books</a>
                </div>

                <!-- Borrowings List -->
                <div x-show="!loading.borrowings && borrowings.length > 0" class="space-y-4">
                    <template x-for="borrowing in borrowings.slice(0, 3)" :key="borrowing.id">
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <!-- Book Cover Placeholder -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Book Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 truncate" x-text="borrowing.book?.title || 'Unknown Book'"></h3>
                                <p class="text-sm text-gray-600" x-text="borrowing.book?.author || 'Unknown Author'"></p>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-xs text-gray-500">Due: <span x-text="formatDate(borrowing.due_date)"></span></span>
                                    <span class="text-xs font-medium" :class="getDaysLeftClass(borrowing.due_date)" x-text="getDaysLeft(borrowing.due_date)"></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                      :class="getBorrowingStatusClass(borrowing)" 
                                      x-text="getBorrowingStatus(borrowing)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Recommendations - 1/3 width -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-display font-bold text-gray-900">Recommended</h2>
                    <a href="<?= site_url('member/books/search') ?>" class="btn btn-outline text-sm">Browse All</a>
                </div>

                <!-- Loading State -->
                <div x-show="loading.recommendations" class="text-center py-8">
                    <svg class="animate-spin mx-auto w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600 text-sm mt-2">Loading recommendations...</p>
                </div>

                <!-- Recommendations List -->
                <div x-show="!loading.recommendations" class="space-y-4">
                    <template x-for="book in recommendations.slice(0, 4)" :key="book.id">
                        <div class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors" 
                             @click="viewBookDetail(book.id)">
                            <!-- Book Cover -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-14 bg-gradient-to-br from-primary-100 to-secondary-100 rounded flex items-center justify-center">
                                    <template x-if="book.url_cover">
                                        <img :src="book.url_cover" :alt="book.title" class="w-full h-full object-cover rounded">
                                    </template>
                                    <template x-if="!book.url_cover">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                        </svg>
                                    </template>
                                </div>
                            </div>

                            <!-- Book Info -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 text-sm truncate" x-text="book.title"></h4>
                                <p class="text-xs text-gray-600 truncate" x-text="book.author"></p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500" x-text="book.category"></span>
                                    <span x-show="book.quantity > 0" class="text-xs text-green-600 font-medium">Available</span>
                                    <span x-show="book.quantity <= 0" class="text-xs text-red-600 font-medium">Unavailable</span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <div x-show="recommendations.length === 0" class="text-center py-8">
                        <div class="text-gray-400 mb-2">
                            <svg class="mx-auto w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-sm">No recommendations yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function memberDashboard() {
    return {
        stats: {
            active_borrowings: 0,
            overdue_books: 0,
            total_read: 0
        },
        borrowings: [],
        recommendations: [],
        loading: {
            stats: false,
            borrowings: false,
            recommendations: false
        },
        error: null,

        async loadDashboardData() {
            // Load all dashboard data in parallel
            await Promise.all([
                this.loadStats(),
                this.loadBorrowings(),
                this.loadRecommendations()
            ]);
        },

        async loadStats() {
            this.loading.stats = true;
            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/member/stats') ?>', {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.stats) {
                        this.stats = { ...this.stats, ...data.stats };
                    }
                }
            } catch (error) {
                console.error('Load stats error:', error);
            } finally {
                this.loading.stats = false;
            }
        },

        async loadBorrowings() {
            this.loading.borrowings = true;
            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/borrowings') ?>?status=active&limit=3', {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        this.borrowings = data.borrowings || data.data || [];
                    }
                }
            } catch (error) {
                console.error('Load borrowings error:', error);
            } finally {
                this.loading.borrowings = false;
            }
        },

        async loadRecommendations() {
            this.loading.recommendations = true;
            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/books') ?>?limit=4&sort=popularity', {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        this.recommendations = data.books || data.data || [];
                    }
                }
            } catch (error) {
                console.error('Load recommendations error:', error);
            } finally {
                this.loading.recommendations = false;
            }
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric' 
            });
        },

        getDaysLeft(dueDate) {
            if (!dueDate) return 'N/A';
            const due = new Date(dueDate);
            const now = new Date();
            const diffTime = due - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 0) {
                return `${Math.abs(diffDays)} day${Math.abs(diffDays) !== 1 ? 's' : ''} overdue`;
            } else if (diffDays === 0) {
                return 'Due today';
            } else if (diffDays <= 7) {
                return `${diffDays} day${diffDays !== 1 ? 's' : ''} left`;
            } else {
                return `${diffDays} days left`;
            }
        },

        getDaysLeftClass(dueDate) {
            if (!dueDate) return 'text-gray-500';
            const due = new Date(dueDate);
            const now = new Date();
            const diffTime = due - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 0) return 'text-red-600';
            if (diffDays <= 3) return 'text-warning-600';
            return 'text-gray-500';
        },

        getBorrowingStatus(borrowing) {
            if (!borrowing.due_date) return 'Active';
            
            const due = new Date(borrowing.due_date);
            const now = new Date();
            const diffTime = due - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 0) return 'Overdue';
            if (diffDays <= 3) return 'Due Soon';
            return 'Active';
        },

        getBorrowingStatusClass(borrowing) {
            const status = this.getBorrowingStatus(borrowing);
            switch (status) {
                case 'Overdue': return 'bg-red-100 text-red-700';
                case 'Due Soon': return 'bg-yellow-100 text-yellow-700';
                default: return 'bg-green-100 text-green-700';
            }
        },

        viewBookDetail(bookId) {
            window.location.href = `<?= site_url('member/books/detail') ?>/${bookId}`;
        }
    }
}
</script>
<?= $this->endSection() ?>
