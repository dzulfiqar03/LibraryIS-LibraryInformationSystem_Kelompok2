<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome back! Here's your library summary</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Currently Borrowed -->
    <div class="card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Currently Borrowed</p>
                <p class="text-3xl font-display font-bold text-gray-900 mt-1">3</p>
                <p class="text-xs text-gray-500 mt-2">1 due soon</p>
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
                <p class="text-3xl font-display font-bold text-danger-600 mt-1">$5.00</p>
                <p class="text-xs text-gray-500 mt-2">1 overdue book</p>
            </div>
            <div class="w-12 h-12 bg-danger-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2M7.08 6.47A9.002 9.002 0 0012 2c4.97 0 9.185 3.364 9.92 7.93M3.08 17.53A9.002 9.002 0 0012 22c4.97 0 9.185-3.364 9.92-7.93"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Reservations -->
    <div class="card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Active Reservations</p>
                <p class="text-3xl font-display font-bold text-warning-600 mt-1">2</p>
                <p class="text-xs text-gray-500 mt-2">0 available</p>
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
                <p class="text-3xl font-display font-bold text-success-600 mt-1">Active</p>
                <p class="text-xs text-gray-500 mt-2">Until Dec 31, 2025</p>
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
            <a href="<?= site_url('member/books/search') ?>" class="btn btn-primary w-full text-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>Search Books</span>
            </a>
            <a href="<?= site_url('member/borrowings') ?>" class="btn btn-outline w-full text-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                <span>View Borrowings</span>
            </a>
        </div>
    </div>

    <!-- Current Borrowings - Col Span 2 -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-display font-bold text-gray-900">Currently Borrowed</h2>
                <a href="<?= site_url('member/borrowings') ?>" class="text-sm font-medium text-primary-600 hover:text-primary-700">View All →</a>
            </div>

            <div class="space-y-3">
                <!-- Borrow Item 1 -->
                <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                    <div class="flex gap-4 flex-1">
                        <div class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">The Great Gatsby</h3>
                            <p class="text-sm text-gray-600">by F. Scott Fitzgerald</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-500">Borrowed: Dec 1, 2024</span>
                                <span class="badge badge-success">Due Dec 15</span>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url('member/borrowings/return') ?>" class="text-primary-600 hover:text-primary-700 font-medium text-sm whitespace-nowrap ml-4">
                        Return
                    </a>
                </div>

                <!-- Borrow Item 2 -->
                <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                    <div class="flex gap-4 flex-1">
                        <div class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">To Kill a Mockingbird</h3>
                            <p class="text-sm text-gray-600">by Harper Lee</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-500">Borrowed: Dec 5, 2024</span>
                                <span class="badge badge-warning">Due Dec 19</span>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url('member/borrowings/return') ?>" class="text-primary-600 hover:text-primary-700 font-medium text-sm whitespace-nowrap ml-4">
                        Return
                    </a>
                </div>

                <!-- Borrow Item 3 - Overdue -->
                <div class="flex items-start justify-between p-4 border border-danger-200 bg-danger-50 rounded-lg hover:border-danger-300 transition-colors">
                    <div class="flex gap-4 flex-1">
                        <div class="w-12 h-16 bg-danger-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">1984</h3>
                            <p class="text-sm text-gray-600">by George Orwell</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-danger-700">Borrowed: Nov 20, 2024</span>
                                <span class="badge bg-danger-200 text-danger-900">Overdue (3 days)</span>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url('member/borrowings/return') ?>" class="text-danger-600 hover:text-danger-700 font-medium text-sm whitespace-nowrap ml-4">
                        Return Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recommendations Section -->
<div class="card">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-display font-bold text-gray-900">Recommended For You</h2>
        <a href="<?= site_url('member/books/recommendations') ?>" class="text-sm font-medium text-primary-600 hover:text-primary-700">View All →</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <!-- Book Card -->
        <div class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors">The Catcher in the Rye</h3>
            <p class="text-xs text-gray-600 mt-1">J.D. Salinger</p>
            <div class="flex items-center gap-1 mt-2">
                <span class="text-yellow-400">★</span>
                <span class="text-xs text-gray-600">4.2 (120)</span>
            </div>
        </div>

        <!-- Book Card -->
        <div class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors">Brave New World</h3>
            <p class="text-xs text-gray-600 mt-1">Aldous Huxley</p>
            <div class="flex items-center gap-1 mt-2">
                <span class="text-yellow-400">★</span>
                <span class="text-xs text-gray-600">4.0 (95)</span>
            </div>
        </div>

        <!-- Book Card -->
        <div class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors">Pride and Prejudice</h3>
            <p class="text-xs text-gray-600 mt-1">Jane Austen</p>
            <div class="flex items-center gap-1 mt-2">
                <span class="text-yellow-400">★</span>
                <span class="text-xs text-gray-600">4.6 (340)</span>
            </div>
        </div>

        <!-- Book Card -->
        <div class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors">Wuthering Heights</h3>
            <p class="text-xs text-gray-600 mt-1">Emily Brontë</p>
            <div class="flex items-center gap-1 mt-2">
                <span class="text-yellow-400">★</span>
                <span class="text-xs text-gray-600">3.9 (210)</span>
            </div>
        </div>

        <!-- Book Card -->
        <div class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg aspect-[3/4] flex items-center justify-center mb-3 group-hover:shadow-md transition-all">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-primary-600 transition-colors">Jane Eyre</h3>
            <p class="text-xs text-gray-600 mt-1">Charlotte Brontë</p>
            <div class="flex items-center gap-1 mt-2">
                <span class="text-yellow-400">★</span>
                <span class="text-xs text-gray-600">4.3 (280)</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
