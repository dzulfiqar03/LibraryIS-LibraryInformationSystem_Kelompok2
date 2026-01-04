<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-gradient-to-b from-white to-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-gray-900 text-lg">LibraryIS</span>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    <a href="<?= site_url('auth/login') ?>" class="text-gray-700 hover:text-primary-600 font-medium text-sm">
                        Sign In
                    </a>
                    <a href="<?= site_url('auth/register') ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg font-medium text-sm hover:bg-primary-700 transition">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 rounded-full">
                    <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                    <span class="text-sm font-medium text-primary-600">Digital Library Management</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-display font-bold text-gray-900 leading-tight">
                    Discover Your Next Great Read
                </h1>

                <p class="text-lg text-gray-600 leading-relaxed">
                    LibraryIS is a modern digital library management system that makes discovering, borrowing, and managing books easy and enjoyable.
                </p>

                <!-- Features List -->
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-success-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Browse thousands of books</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-success-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Easy book borrowing and returns</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-success-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Personalized recommendations</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-success-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Track your reading history</span>
                    </li>
                </ul>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="<?= site_url('auth/login') ?>" class="px-6 py-3 bg-primary-600 text-white rounded-lg font-medium text-center hover:bg-primary-700 transition">
                        Sign In to Your Account
                    </a>
                    <a href="<?= site_url('auth/register') ?>" class="px-6 py-3 border-2 border-primary-600 text-primary-600 rounded-lg font-medium text-center hover:bg-primary-50 transition">
                        Create New Account
                    </a>
                </div>
            </div>

            <!-- Right Illustration -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-400/20 to-secondary-400/20 rounded-3xl blur-3xl"></div>
                    <div class="relative bg-gradient-to-br from-primary-50 to-secondary-50 rounded-3xl p-12 border border-primary-200/50">
                        <div class="space-y-4">
                            <!-- Book Card 1 -->
                            <div class="bg-white rounded-lg p-4 flex gap-4 shadow-md">
                                <div class="w-12 h-16 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex-shrink-0"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-sm">The Great Gatsby</p>
                                    <p class="text-xs text-gray-600">F. Scott Fitzgerald</p>
                                    <div class="flex gap-1 mt-2">
                                        <span class="text-yellow-400 text-xs">★★★★★</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Book Card 2 -->
                            <div class="bg-white rounded-lg p-4 flex gap-4 shadow-md">
                                <div class="w-12 h-16 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-lg flex-shrink-0"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-sm">To Kill a Mockingbird</p>
                                    <p class="text-xs text-gray-600">Harper Lee</p>
                                    <div class="flex gap-1 mt-2">
                                        <span class="text-yellow-400 text-xs">★★★★★</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Book Card 3 -->
                            <div class="bg-white rounded-lg p-4 flex gap-4 shadow-md">
                                <div class="w-12 h-16 bg-gradient-to-br from-warning-400 to-warning-600 rounded-lg flex-shrink-0"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-sm">1984</p>
                                    <p class="text-xs text-gray-600">George Orwell</p>
                                    <div class="flex gap-1 mt-2">
                                        <span class="text-yellow-400 text-xs">★★★★☆</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-20 sm:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-gray-900 mb-4">
                    Everything You Need
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    LibraryIS provides all the features you need to enjoy reading
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">Advanced Search</h3>
                    <p class="text-gray-600 text-sm">Find books by title, author, category, and more with our powerful search engine.</p>
                </div>

                <!-- Feature 2 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">Easy Borrowing</h3>
                    <p class="text-gray-600 text-sm">Borrow and return books with just a few clicks. Track your borrowing history anytime.</p>
                </div>

                <!-- Feature 3 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">Personalized Recommendations</h3>
                    <p class="text-gray-600 text-sm">Get book recommendations tailored to your reading preferences and interests.</p>
                </div>

                <!-- Feature 4 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">Smart Notifications</h3>
                    <p class="text-gray-600 text-sm">Get reminders for due dates, new arrivals, and reserved books you're waiting for.</p>
                </div>

                <!-- Feature 5 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-danger-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">Fine Management</h3>
                    <p class="text-gray-600 text-sm">Manage your library fines with easy payment options and transparent billing.</p>
                </div>

                <!-- Feature 6 -->
                <div class="card text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-gray-900 mb-2">User Profiles</h3>
                    <p class="text-gray-600 text-sm">Manage your profile, reading history, preferences, and account settings easily.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-primary-600 to-secondary-600 py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <p class="text-3xl sm:text-4xl font-display font-bold">5K+</p>
                    <p class="text-sm sm:text-base mt-2 text-primary-100">Books in Catalog</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-display font-bold">2K+</p>
                    <p class="text-sm sm:text-base mt-2 text-primary-100">Active Members</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-display font-bold">10K+</p>
                    <p class="text-sm sm:text-base mt-2 text-primary-100">Books Borrowed</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-display font-bold">4.8★</p>
                    <p class="text-sm sm:text-base mt-2 text-primary-100">User Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
        <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-3xl p-12 sm:p-16 text-center border border-primary-200/50">
            <h2 class="text-3xl sm:text-4xl font-display font-bold text-gray-900 mb-4">
                Ready to Start Reading?
            </h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Join LibraryIS today and discover your next favorite book from our extensive collection.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= site_url('auth/register') ?>" class="px-6 py-3 bg-primary-600 text-white rounded-lg font-medium text-center hover:bg-primary-700 transition">
                    Create Free Account
                </a>
                <a href="<?= site_url('auth/login') ?>" class="px-6 py-3 border-2 border-primary-600 text-primary-600 rounded-lg font-medium text-center hover:bg-primary-50 transition">
                    Already have an account?
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-white">LibraryIS</span>
                    </div>
                    <p class="text-sm text-gray-400">A modern digital library management system.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-800 pt-8 mt-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <p class="text-sm text-gray-400">
                        &copy; 2025 LibraryIS. All rights reserved.
                    </p>
                    <div class="flex gap-6 mt-4 md:mt-0">
                        <a href="#" class="hover:text-white transition">Twitter</a>
                        <a href="#" class="hover:text-white transition">Facebook</a>
                        <a href="#" class="hover:text-white transition">GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<?= $this->endSection() ?>
