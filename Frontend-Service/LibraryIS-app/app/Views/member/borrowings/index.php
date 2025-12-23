<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>My Borrowings<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">My Borrowings</h1>
    <p class="text-gray-600 mt-1">View and manage your borrowed books</p>
</div>

<!-- Tabs -->
<div class="flex gap-4 mb-6 border-b border-gray-200">
    <button class="px-4 py-3 border-b-2 border-primary-600 text-primary-600 font-medium">
        Active (3)
    </button>
    <button class="px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-900 font-medium">
        History (12)
    </button>
</div>

<!-- Active Borrowings -->
<div class="space-y-4">
    <!-- Borrowing Item 1 -->
    <div class="card">
        <div class="flex gap-4">
            <div class="flex-shrink-0">
                <div class="w-16 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">The Great Gatsby</h3>
                        <p class="text-gray-600">F. Scott Fitzgerald</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-success-100 text-success-700">
                        Active
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-600">Borrowed on</p>
                        <p class="font-medium text-gray-900">Dec 10, 2024</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Due date</p>
                        <p class="font-medium text-gray-900">Dec 24, 2024</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Days left</p>
                        <p class="font-medium text-gray-900">5 days</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="#" class="btn-secondary text-sm">View Details</a>
                    <button class="btn-primary text-sm">Renew</button>
                    <button class="btn-outline text-sm">Return</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing Item 2 -->
    <div class="card">
        <div class="flex gap-4">
            <div class="flex-shrink-0">
                <div class="w-16 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">To Kill a Mockingbird</h3>
                        <p class="text-gray-600">Harper Lee</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-warning-100 text-warning-700">
                        Due Soon
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-600">Borrowed on</p>
                        <p class="font-medium text-gray-900">Dec 01, 2024</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Due date</p>
                        <p class="font-medium text-gray-900">Dec 15, 2024</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Days left</p>
                        <p class="font-medium text-warning-600">1 day</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="#" class="btn-secondary text-sm">View Details</a>
                    <button class="btn-primary text-sm">Renew</button>
                    <button class="btn-outline text-sm">Return</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing Item 3 -->
    <div class="card">
        <div class="flex gap-4">
            <div class="flex-shrink-0">
                <div class="w-16 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">1984</h3>
                        <p class="text-gray-600">George Orwell</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-success-100 text-success-700">
                        Active
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-600">Borrowed on</p>
                        <p class="font-medium text-gray-900">Dec 18, 2024</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Due date</p>
                        <p class="font-medium text-gray-900">Jan 01, 2025</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Days left</p>
                        <p class="font-medium text-gray-900">14 days</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="#" class="btn-secondary text-sm">View Details</a>
                    <button class="btn-primary text-sm">Renew</button>
                    <button class="btn-outline text-sm">Return</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
