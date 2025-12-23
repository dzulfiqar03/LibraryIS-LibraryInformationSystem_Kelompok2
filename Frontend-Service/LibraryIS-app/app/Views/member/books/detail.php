<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Book Details<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Breadcrumb -->
<nav class="flex gap-2 text-sm mb-6">
    <a href="<?= site_url('/') ?>" class="text-gray-600 hover:text-gray-900">Home</a>
    <span class="text-gray-400">/</span>
    <a href="<?= site_url('member/books/search') ?>" class="text-gray-600 hover:text-gray-900">Books</a>
    <span class="text-gray-400">/</span>
    <span class="text-gray-900 font-medium">Book Details</span>
</nav>

<!-- Book Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Book Cover & Actions -->
    <div>
        <div class="bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg h-80 flex items-center justify-center mb-6 sticky top-4">
            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
            </svg>
        </div>

        <div class="space-y-3">
            <button class="btn-primary w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Borrow This Book
            </button>
            <button class="btn-secondary w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                </svg>
                Add to Wishlist
            </button>
            <button class="btn-outline w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C9.922 10.938 12.114 9 14.5 9c.658 0 1.297.098 1.9.28m-1.646 2.645L12 13m-4.223 1.77c-.693.692-1.18 1.55-1.327 2.53m4.368-8.076A10 10 0 1 1 5 12a9.994 9.994 0 015.922 1.756z"></path>
                </svg>
                Share
            </button>
        </div>
    </div>

    <!-- Book Information -->
    <div class="lg:col-span-2">
        <!-- Status -->
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-success-100 text-success-700">
                Available (2 copies)
            </span>
        </div>

        <!-- Title & Author -->
        <h1 class="text-4xl font-display font-bold text-gray-900 mb-2">The Great Gatsby</h1>
        <p class="text-xl text-gray-600 mb-6">by F. Scott Fitzgerald</p>

        <!-- Rating -->
        <div class="flex items-center gap-4 mb-6">
            <div class="flex gap-1">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                <?php endfor; ?>
            </div>
            <span class="text-gray-600">4.8 out of 5 (248 reviews)</span>
        </div>

        <!-- Book Details Table -->
        <div class="card mb-8">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Author</span>
                    <span class="font-medium text-gray-900">F. Scott Fitzgerald</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Published</span>
                    <span class="font-medium text-gray-900">April 10, 1925</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Publisher</span>
                    <span class="font-medium text-gray-900">Scribner</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Pages</span>
                    <span class="font-medium text-gray-900">180</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Language</span>
                    <span class="font-medium text-gray-900">English</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">ISBN</span>
                    <span class="font-medium text-gray-900">978-0-7432-7356-5</span>
                </div>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Category</span>
                    <span class="font-medium text-gray-900">Fiction</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card">
            <h2 class="text-xl font-bold text-gray-900 mb-3">Description</h2>
            <p class="text-gray-600 leading-relaxed">
                The Great Gatsby is a classic of American literature that has been acclaimed by generations of readers. 
                The novel is set in the Jazz Age and deals with important themes including the American Dream, 
                social class, love, and the American past. It is considered a masterpiece of American literature and 
                is widely read in high schools and universities.
            </p>

            <h3 class="text-lg font-bold text-gray-900 mt-6 mb-2">Why Read This Book?</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>A timeless love story set against the backdrop of the Jazz Age</li>
                <li>Explores themes of ambition, wealth, and social class</li>
                <li>Beautiful prose and memorable characters</li>
                <li>Essential reading for literature lovers and students</li>
                <li>Inspired numerous adaptations in film and stage</li>
            </ul>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="card mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Reader Reviews</h2>

    <!-- Filter Reviews -->
    <div class="flex gap-2 mb-6 pb-4 border-b border-gray-200">
        <button class="px-3 py-2 rounded-lg bg-primary-100 text-primary-700 font-medium">
            All Reviews
        </button>
        <button class="px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
            5 Stars
        </button>
        <button class="px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
            4 Stars
        </button>
        <button class="px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
            3 Stars
        </button>
    </div>

    <!-- Review Items -->
    <div class="space-y-6">
        <!-- Review 1 -->
        <div>
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-medium text-gray-900">Sarah Johnson</p>
                    <p class="text-sm text-gray-600">Verified Member • 2 weeks ago</p>
                </div>
                <div class="flex gap-0.5">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                </div>
            </div>
            <p class="text-gray-700">
                An absolutely stunning novel. Fitzgerald's prose is beautiful and the characters are so compelling. 
                I couldn't put it down!
            </p>
            <div class="mt-3 flex gap-3 text-sm">
                <button class="text-gray-600 hover:text-gray-900">👍 Helpful (23)</button>
                <button class="text-gray-600 hover:text-gray-900">👎 Not helpful (1)</button>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="pt-6 border-t border-gray-200">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-medium text-gray-900">Michael Chen</p>
                    <p class="text-sm text-gray-600">Verified Member • 1 month ago</p>
                </div>
                <div class="flex gap-0.5">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-gray-700">
                A great read, though some parts felt slow. Still, it's a classic for a reason and worth your time.
            </p>
            <div class="mt-3 flex gap-3 text-sm">
                <button class="text-gray-600 hover:text-gray-900">👍 Helpful (15)</button>
                <button class="text-gray-600 hover:text-gray-900">👎 Not helpful (2)</button>
            </div>
        </div>
    </div>
</div>

<!-- Similar Books -->
<div class="card">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Similar Books You Might Like</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Similar Book 1 -->
        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
            <div class="bg-gradient-to-br from-primary-100 to-secondary-100 h-32 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <div class="p-3">
                <p class="font-medium text-gray-900 line-clamp-1">Tender Is the Night</p>
                <p class="text-xs text-gray-600">F. Scott Fitzgerald</p>
                <button class="mt-2 btn-primary w-full text-xs py-1">View</button>
            </div>
        </div>

        <!-- Similar Book 2 -->
        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
            <div class="bg-gradient-to-br from-primary-100 to-secondary-100 h-32 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <div class="p-3">
                <p class="font-medium text-gray-900 line-clamp-1">The Beautiful and Damned</p>
                <p class="text-xs text-gray-600">F. Scott Fitzgerald</p>
                <button class="mt-2 btn-primary w-full text-xs py-1">View</button>
            </div>
        </div>

        <!-- Similar Book 3 -->
        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
            <div class="bg-gradient-to-br from-primary-100 to-secondary-100 h-32 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <div class="p-3">
                <p class="font-medium text-gray-900 line-clamp-1">The Sun Also Rises</p>
                <p class="text-xs text-gray-600">Ernest Hemingway</p>
                <button class="mt-2 btn-primary w-full text-xs py-1">View</button>
            </div>
        </div>

        <!-- Similar Book 4 -->
        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
            <div class="bg-gradient-to-br from-primary-100 to-secondary-100 h-32 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <div class="p-3">
                <p class="font-medium text-gray-900 line-clamp-1">Moby Dick</p>
                <p class="text-xs text-gray-600">Herman Melville</p>
                <button class="mt-2 btn-primary w-full text-xs py-1">View</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
