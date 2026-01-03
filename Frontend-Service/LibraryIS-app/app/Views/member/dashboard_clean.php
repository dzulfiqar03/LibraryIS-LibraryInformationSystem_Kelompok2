<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="memberDashboard()" x-init="loadDashboardData()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Welcome back, <span class="font-medium"><?= esc(session()->get('user')['name'] ?? 'Member') ?></span>! Here's your library summary</p>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <svg class="animate-spin mx-auto w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="text-gray-600 mt-2">Loading dashboard...</p>
    </div>

    <!-- Dashboard Content -->
    <div x-show="!loading">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Currently Borrowed -->
            <div class="card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Currently Borrowed</p>
                        <p class="text-3xl font-display font-bold text-gray-900 mt-1" x-text="stats.activeBorrowings"></p>
                        <p class="text-xs text-gray-500 mt-2" x-text="stats.dueSoon > 0 ? stats.dueSoon + ' due soon' : 'All current'"></p>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Outstanding Fines -->
            <div class="card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Outstanding Fines</p>
                        <p class="text-3xl font-display font-bold mt-1" :class="stats.outstandingFines > 0 ? 'text-red-600' : 'text-green-600'">
                            $<span x-text="stats.outstandingFines.toFixed(2)"></span>
                        </p>
                        <p class="text-xs text-gray-500 mt-2" x-text="stats.overdueBooks > 0 ? stats.overdueBooks + ' overdue book' + (stats.overdueBooks > 1 ? 's' : '') : 'No overdue books'"></p>
                    </div>
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" :class="stats.outstandingFines > 0 ? 'bg-red-100' : 'bg-green-100'">
                        <svg class="w-6 h-6" :class="stats.outstandingFines > 0 ? 'text-red-600' : 'text-green-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <template x-if="stats.outstandingFines > 0">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2M7.08 6.47A9.002 9.002 0 0012 2c4.97 0 9.185 3.364 9.92 7.93M3.08 17.53A9.002 9.002 0 0012 22c4.97 0 9.185-3.364 9.92-7.93"></path>
                            </template>
                            <template x-if="stats.outstandingFines === 0">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </template>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reservations -->
            <div class="card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active Reservations</p>
                        <p class="text-3xl font-display font-bold text-warning-600 mt-1" x-text="stats.activeReservations"></p>
                        <p class="text-xs text-gray-500 mt-2" x-text="stats.availableReservations > 0 ? stats.availableReservations + ' available' : 'None available'"></p>
                    </div>
                    <div class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m0-6.5h6m-6 0V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0h6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Membership Status -->
            <div class="card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Membership Status</p>
                        <p class="text-3xl font-display font-bold text-success-600 mt-1" x-text="stats.membershipStatus"></p>
                        <p class="text-xs text-gray-500 mt-2" x-text="'Member since ' + stats.memberSince"></p>
                    </div>
                    <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Current Borrowings -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Actions -->
            <div class="card">
                <h2 class="text-lg font-display font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="<?= site_url('member/books/search') ?>" class="btn btn-primary w-full flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Search Books</span>
                    </a>
                    <a href="<?= site_url('member/borrowings') ?>" class="btn btn-outline w-full flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <span>View Borrowings</span>
                    </a>
                    <button @click="loadDashboardData()" class="btn btn-outline w-full flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>

            <!-- Current Borrowings - Col Span 2 -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-display font-bold text-gray-900">Currently Borrowed</h2>
                        <a href="<?= site_url('member/borrowings') ?>" class="text-sm font-medium text-primary-600 hover:text-primary-700">View All →</a>
                    </div>

                    <!-- No Borrowings -->
                    <div x-show="recentBorrowings.length === 0" class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 mb-2">No books currently borrowed</p>
                        <a href="<?= site_url('member/books/search') ?>" class="btn btn-primary">Browse Books</a>
                    </div>

                    <!-- Borrowings List -->
                    <div x-show="recentBorrowings.length > 0" class="space-y-3">
                        <template x-for="borrowing in recentBorrowings" :key="borrowing.id">
                            <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors" :class="isOverdue(borrowing.due_date) ? 'border-red-200 bg-red-50' : ''">
                                <div class="flex gap-4 flex-1">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded flex items-center justify-center">
                                            <template x-if="borrowing.book?.url_cover">
                                                <img :src="borrowing.book.url_cover" :alt="borrowing.book.title" class="w-full h-full object-cover rounded">
                                            </template>
                                            <template x-if="!borrowing.book?.url_cover">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate" x-text="borrowing.book?.title || 'Unknown Title'"></h3>
                                        <p class="text-sm text-gray-600 truncate" x-text="borrowing.book?.author || 'Unknown Author'"></p>
                                        <p class="text-xs mt-1" :class="getDueDateClass(borrowing.due_date)" x-text="'Due: ' + formatDate(borrowing.due_date)"></p>
                                    </div>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button @click="viewBookDetail(borrowing.book_id)" class="text-primary-600 hover:text-primary-700 font-medium text-sm whitespace-nowrap">
                                        View →
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-display font-bold text-gray-900">Recommended For You</h2>
                <a href="<?= site_url('member/books/search') ?>" class="text-sm font-medium text-primary-600 hover:text-primary-700">Browse All →</a>
            </div>

            <!-- Loading recommendations -->
            <div x-show="recommendationsLoading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <template x-for="i in 5" :key="i">
                    <div class="animate-pulse">
                        <div class="bg-gray-200 rounded-lg aspect-[3/4] mb-3"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                    </div>
                </template>
            </div>

            <!-- Recommendations -->
            <div x-show="!recommendationsLoading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <template x-for="book in recommendations" :key="book.id">
                    <div class="group cursor-pointer" @click="viewBookDetail(book.id)">
                        <div class="bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                            <template x-if="book.url_cover">
                                <img :src="book.url_cover" :alt="book.title" class="w-full h-full object-cover rounded-lg">
                            </template>
                            <template x-if="!book.url_cover">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                </svg>
                            </template>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors line-clamp-1" x-text="book.title"></h3>
                        <p class="text-xs text-gray-600 mt-1 line-clamp-1" x-text="book.author"></p>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-yellow-400">★</span>
                            <span class="text-xs text-gray-600" x-text="book.rating || '4.0'"></span>
                            <span class="text-xs text-gray-400">(<span x-text="book.reviews_count || '0'"></span>)</span>
                        </div>
                    </div>
                </template>

                <!-- Show placeholder if no recommendations -->
                <template x-if="recommendations.length === 0">
                    <div class="col-span-full text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600">Start borrowing books to get personalized recommendations!</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
function memberDashboard() {
    return {
        loading: true,
        recommendationsLoading: false,
        stats: {
            activeBorrowings: 0,
            dueSoon: 0,
            outstandingFines: 0,
            overdueBooks: 0,
            activeReservations: 0,
            availableReservations: 0,
            membershipStatus: 'Active',
            memberSince: '2025'
        },
        recentBorrowings: [],
        recommendations: [],

        async loadDashboardData() {
            this.loading = true;
            
            // Load data in parallel
            await Promise.all([
                this.loadStats(),
                this.loadRecentBorrowings(),
                this.loadRecommendations()
            ]);
            
            this.loading = false;
        },

        async loadStats() {
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
                    if (data.success) {
                        this.stats = { ...this.stats, ...data.stats };
                    }
                }
            } catch (error) {
                console.error('Load stats error:', error);
                // Use default values on error
            }
        },

        async loadRecentBorrowings() {
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
                        this.recentBorrowings = data.borrowings || data.data || [];
                        this.stats.activeBorrowings = this.recentBorrowings.length;
                        this.stats.dueSoon = this.recentBorrowings.filter(b => this.isDueSoon(b.due_date)).length;
                    }
                }
            } catch (error) {
                console.error('Load borrowings error:', error);
                this.recentBorrowings = [];
            }
        },

        async loadRecommendations() {
            this.recommendationsLoading = true;
            
            try {
                const token = '<?= session()->get('jwt_token') ?? '' ?>';
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch('<?= site_url('api/books') ?>?limit=5&sort=popularity', {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        this.recommendations = (data.books || data.data || []).slice(0, 5);
                    }
                }
            } catch (error) {
                console.error('Load recommendations error:', error);
                this.recommendations = [];
            } finally {
                this.recommendationsLoading = false;
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

        isOverdue(dueDate) {
            if (!dueDate) return false;
            return new Date(dueDate) < new Date();
        },

        isDueSoon(dueDate) {
            if (!dueDate) return false;
            const due = new Date(dueDate);
            const now = new Date();
            const diffDays = Math.ceil((due - now) / (1000 * 60 * 60 * 24));
            return diffDays <= 3 && diffDays >= 0;
        },

        getDueDateClass(dueDate) {
            if (this.isOverdue(dueDate)) return 'text-red-600';
            if (this.isDueSoon(dueDate)) return 'text-warning-600';
            return 'text-gray-600';
        },

        viewBookDetail(bookId) {
            window.location.href = `<?= site_url('member/books/detail') ?>/${bookId}`;
        }
    }
}
</script>
</div>
<?= $this->endSection() ?>