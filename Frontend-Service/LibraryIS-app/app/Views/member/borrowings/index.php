<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>My Borrowings<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="borrowingsPage()" x-init="loadBorrowings()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">My Borrowings</h1>
        <p class="text-gray-600 mt-1">View and manage your borrowed books</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-4 mb-6 border-b border-gray-200">
        <button 
            @click="activeTab = 'active'; loadBorrowings()" 
            :class="activeTab === 'active' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-600 hover:text-gray-900'"
            class="px-4 py-3 border-b-2 font-medium"
        >
            Active (<span x-text="activeBorrowings.length"></span>)
        </button>
        <button 
            @click="activeTab = 'history'; loadBorrowings()" 
            :class="activeTab === 'history' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-600 hover:text-gray-900'"
            class="px-4 py-3 border-b-2 font-medium"
        >
            History (<span x-text="historyBorrowings.length"></span>)
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <svg class="animate-spin mx-auto w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="text-gray-600 mt-2">Loading borrowings...</p>
    </div>

    <!-- Error State -->
    <div x-show="error && !loading" class="text-center py-12">
        <div class="text-red-600 mb-4">
            <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2"></path>
            </svg>
        </div>
        <p class="text-gray-600" x-text="error"></p>
        <button @click="loadBorrowings()" class="btn btn-primary mt-4">Try Again</button>
    </div>

    <!-- Active Borrowings -->
    <div x-show="activeTab === 'active' && !loading && !error">
        <div x-show="activeBorrowings.length === 0" class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <p class="text-gray-600 text-lg mb-2">No active borrowings</p>
            <p class="text-gray-500">Start by borrowing some books!</p>
            <a href="<?= site_url('member/books/search') ?>" class="btn btn-primary mt-4">Browse Books</a>
        </div>

        <div x-show="activeBorrowings.length > 0" class="space-y-4">
            <template x-for="borrowing in activeBorrowings" :key="borrowing.id">
                <div class="card">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg flex items-center justify-center">
                                <template x-if="borrowing.book?.url_cover">
                                    <img :src="borrowing.book.url_cover" :alt="borrowing.book.title" class="w-full h-full object-cover rounded-lg">
                                </template>
                                <template x-if="!borrowing.book?.url_cover">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                </template>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900" x-text="borrowing.book?.title || 'Unknown Title'"></h3>
                                    <p class="text-gray-600" x-text="borrowing.book?.author || 'Unknown Author'"></p>
                                </div>
                                <span 
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                                    :class="getBorrowingStatusClass(borrowing)"
                                    x-text="getBorrowingStatus(borrowing)"
                                ></span>
                            </div>

                            <div class="grid grid-cols-3 gap-4 text-sm mb-4">
                                <div>
                                    <p class="text-gray-600">Borrowed on</p>
                                    <p class="font-medium text-gray-900" x-text="formatDate(borrowing.borrowed_date)"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Due date</p>
                                    <p class="font-medium" :class="isOverdue(borrowing.due_date) ? 'text-red-600' : 'text-gray-900'" x-text="formatDate(borrowing.due_date)"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Days left</p>
                                    <p class="font-medium" :class="getDaysLeftClass(borrowing.due_date)" x-text="getDaysLeft(borrowing.due_date)"></p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="viewBookDetail(borrowing.book_id)" class="btn-secondary text-sm">View Details</button>
                                <template x-if="canRenew(borrowing)">
                                    <button @click="renewBook(borrowing.id)" class="btn-primary text-sm" :disabled="renewLoading">
                                        <span x-show="!renewLoading">Renew</span>
                                        <span x-show="renewLoading">Renewing...</span>
                                    </button>
                                </template>
                                <button @click="returnBook(borrowing.id, borrowing.book_id)" class="btn-outline text-sm" :disabled="returnLoading">
                                    <span x-show="!returnLoading">Return</span>
                                    <span x-show="returnLoading">Returning...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- History Borrowings -->
    <div x-show="activeTab === 'history' && !loading && !error">
        <div x-show="historyBorrowings.length === 0" class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-600 text-lg mb-2">No borrowing history</p>
            <p class="text-gray-500">Your past borrowings will appear here</p>
        </div>

        <div x-show="historyBorrowings.length > 0" class="space-y-4">
            <template x-for="borrowing in historyBorrowings" :key="borrowing.id">
                <div class="card">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                <template x-if="borrowing.book?.url_cover">
                                    <img :src="borrowing.book.url_cover" :alt="borrowing.book.title" class="w-full h-full object-cover rounded-lg opacity-75">
                                </template>
                                <template x-if="!borrowing.book?.url_cover">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                </template>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900" x-text="borrowing.book?.title || 'Unknown Title'"></h3>
                                    <p class="text-gray-600" x-text="borrowing.book?.author || 'Unknown Author'"></p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    Returned
                                </span>
                            </div>

                            <div class="grid grid-cols-3 gap-4 text-sm mb-4">
                                <div>
                                    <p class="text-gray-600">Borrowed</p>
                                    <p class="font-medium text-gray-900" x-text="formatDate(borrowing.borrowed_date)"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Due date</p>
                                    <p class="font-medium text-gray-900" x-text="formatDate(borrowing.due_date)"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Returned</p>
                                    <p class="font-medium text-gray-900" x-text="formatDate(borrowing.returned_date)"></p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="viewBookDetail(borrowing.book_id)" class="btn-secondary text-sm">View Book</button>
                                <button @click="borrowAgain(borrowing.book_id)" class="btn-outline text-sm">Borrow Again</button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function borrowingsPage() {
    return {
        activeTab: 'active',
        activeBorrowings: [],
        historyBorrowings: [],
        loading: false,
        error: null,
        renewLoading: false,
        returnLoading: false,

        async loadBorrowings() {
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

                const status = this.activeTab === 'active' ? 'active' : 'returned';
                const response = await fetch(`<?= site_url('api/borrowings') ?>?status=${status}`, {
                    method: 'GET',
                    headers: headers,
                    credentials: 'include'
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();
                
                if (data.success === false) {
                    throw new Error(data.message || 'Failed to load borrowings');
                }

                if (this.activeTab === 'active') {
                    this.activeBorrowings = data.borrowings || data.data || [];
                } else {
                    this.historyBorrowings = data.borrowings || data.data || [];
                }

            } catch (error) {
                console.error('Load borrowings error:', error);
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        },

        isOverdue(dueDate) {
            if (!dueDate) return false;
            return new Date(dueDate) < new Date();
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
            } else {
                return `${diffDays} day${diffDays !== 1 ? 's' : ''} left`;
            }
        },

        getDaysLeftClass(dueDate) {
            if (!dueDate) return 'text-gray-900';
            const due = new Date(dueDate);
            const now = new Date();
            const diffTime = due - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 0) return 'text-red-600';
            if (diffDays <= 3) return 'text-warning-600';
            return 'text-gray-900';
        },

        getBorrowingStatus(borrowing) {
            if (borrowing.returned_date) return 'Returned';
            if (this.isOverdue(borrowing.due_date)) return 'Overdue';
            
            const due = new Date(borrowing.due_date);
            const now = new Date();
            const diffDays = Math.ceil((due - now) / (1000 * 60 * 60 * 24));
            
            if (diffDays <= 3) return 'Due Soon';
            return 'Active';
        },

        getBorrowingStatusClass(borrowing) {
            const status = this.getBorrowingStatus(borrowing);
            switch (status) {
                case 'Overdue': return 'bg-red-100 text-red-700';
                case 'Due Soon': return 'bg-yellow-100 text-yellow-700';
                case 'Active': return 'bg-green-100 text-green-700';
                default: return 'bg-gray-100 text-gray-700';
            }
        },

        canRenew(borrowing) {
            return !borrowing.returned_date && !this.isOverdue(borrowing.due_date);
        },

        viewBookDetail(bookId) {
            window.location.href = `<?= site_url('member/books/detail') ?>/${bookId}`;
        },

        async renewBook(borrowingId) {
            if (!confirm('Do you want to renew this book?')) return;

            this.renewLoading = true;
            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const headers = {
                    'Content-Type': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch(`<?= site_url('api/borrowings/renew') ?>`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ borrowing_id: borrowingId }),
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success) {
                    alert('Book renewed successfully!');
                    this.loadBorrowings(); // Refresh the list
                } else {
                    alert(data.message || 'Failed to renew book');
                }
            } catch (error) {
                console.error('Renew error:', error);
                alert('Error renewing book: ' + error.message);
            } finally {
                this.renewLoading = false;
            }
        },

        async returnBook(borrowingId, bookId) {
            if (!confirm('Do you want to return this book?')) return;

            this.returnLoading = true;
            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const headers = {
                    'Content-Type': 'application/json'
                };
                
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }

                const response = await fetch(`<?= site_url('api/borrowings/return') ?>`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ borrowing_id: borrowingId, book_id: bookId }),
                    credentials: 'include'
                });

                const data = await response.json();

                if (data.success) {
                    alert('Book returned successfully!');
                    this.loadBorrowings(); // Refresh the list
                } else {
                    alert(data.message || 'Failed to return book');
                }
            } catch (error) {
                console.error('Return error:', error);
                alert('Error returning book: ' + error.message);
            } finally {
                this.returnLoading = false;
            }
        },

        async borrowAgain(bookId) {
            if (!confirm('Do you want to borrow this book again?')) return;

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
                    this.activeTab = 'active';
                    this.loadBorrowings();
                } else {
                    alert(data.message || 'Failed to borrow book');
                }
            } catch (error) {
                console.error('Borrow error:', error);
                alert('Error borrowing book: ' + error.message);
            }
        }
    }
}
</script>
<?= $this->endSection() ?>

