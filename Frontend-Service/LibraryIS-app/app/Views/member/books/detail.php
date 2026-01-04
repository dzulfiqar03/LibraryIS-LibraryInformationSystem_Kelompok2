<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Book Details<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="bookDetail()">
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
                <?php if (!empty($book['url_cover'])): ?>
                    <img src="<?= esc($book['url_cover']) ?>" alt="<?= esc($book['title'] ?? 'Book Cover') ?>" class="w-full h-full object-cover rounded-lg">
                <?php else: ?>
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                <?php endif; ?>
            </div>

            <div class="space-y-3">
                <?php if (($book['quantity'] ?? 0) > 0): ?>
                    <button @click="borrowBook(<?= $book['id'] ?? 0 ?>)" :disabled="loading" class="btn-primary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span x-text="loading ? 'Loading...' : 'Borrow This Book'"></span>
                    </button>
                <?php else: ?>
                    <button class="btn-secondary w-full opacity-50 cursor-not-allowed" disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Not Available
                    </button>
                <?php endif; ?>
                
                <button @click="addToWishlist()" class="btn-outline w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Add to Wishlist
                </button>
            <button @click="shareBook()" class="btn-outline w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C9.922 10.938 12.114 9 14.5 9c.658 0 1.297.098 1.9.28m-1.646 2.645L12 13m-4.223 1.77c-.693.692-1.18 1.55-1.327 2.53m4.368-8.076A10 10 0 1 1 5 12a9.994 9.994 0 015.922 1.756z"></path>
                </svg>
                Share
            </button>
            
            <!-- Debug Button -->
            <button @click="debugTest()" class="btn-outline w-full bg-red-100 text-red-700 border-red-300">
                🔧 Debug API Test
            </button>
        </div>
    </div>

    <!-- Book Information -->
    <div class="lg:col-span-2">
        <!-- Status -->
        <div class="flex items-center gap-2 mb-4">
                <?php if (($book['quantity'] ?? 0) > 0): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-success-100 text-success-700">
                        Available (<?= ($book['quantity'] ?? 0) ?> copies)
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-danger-100 text-danger-700">
                        Not Available
                    </span>
                <?php endif; ?>
            </div>

            <!-- Title & Author -->
            <h1 class="text-4xl font-display font-bold text-gray-900 mb-2"><?= esc($book['title'] ?? 'Unknown Title') ?></h1>
            <p class="text-xl text-gray-600 mb-6">by <?= esc($book['author'] ?? 'Unknown Author') ?></p>
            
            <!-- Rating -->
            <div class="flex items-center gap-3 mb-6">
                <div class="flex items-center">
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
                    <span class="font-medium text-gray-900"><?= esc($book['author'] ?? 'Unknown Author') ?></span>
                </div>
                <?php if (!empty($book['publication_year'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Published</span>
                    <span class="font-medium text-gray-900"><?= esc($book['publication_year']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($book['publisher'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Publisher</span>
                    <span class="font-medium text-gray-900"><?= esc($book['publisher']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($book['pages'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Pages</span>
                    <span class="font-medium text-gray-900"><?= $book['pages'] ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($book['language'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Language</span>
                    <span class="font-medium text-gray-900"><?= esc($book['language']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($book['isbn'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">ISBN</span>
                    <span class="font-medium text-gray-900"><?= esc($book['isbn']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($book['category'])): ?>
                <div class="border-t border-gray-200 pt-4 flex justify-between">
                    <span class="text-gray-600">Category</span>
                    <span class="font-medium text-gray-900"><?= esc($book['category']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <div class="card">
            <h2 class="text-xl font-bold text-gray-900 mb-3">Description</h2>
            <?php if (!empty($book['description'])): ?>
                <p class="text-gray-600 leading-relaxed">
                    <?= nl2br(esc($book['description'])) ?>
                </p>
            <?php else: ?>
                <p class="text-gray-600 leading-relaxed">
                    This book is available in our library. No detailed description is currently available.
                </p>
            <?php endif; ?>

            <?php if (!empty($book['category']) || !empty($book['language'])): ?>
            <h3 class="text-lg font-bold text-gray-900 mt-6 mb-2">Book Details</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <?php if (!empty($book['category'])): ?>
                    <li>Category: <?= esc($book['category']) ?></li>
                <?php endif; ?>
                <?php if (!empty($book['language'])): ?>
                    <li>Language: <?= esc($book['language']) ?></li>
                <?php endif; ?>
                <?php if (!empty($book['pages'])): ?>
                    <li><?= $book['pages'] ?> pages</li>
                <?php endif; ?>
                <?php if (!empty($book['publication_year'])): ?>
                    <li>Published in <?= esc($book['publication_year']) ?></li>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
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

<script>
function bookDetail() {
    return {
        loading: false,
        wishlistAdded: false,

        async borrowBook(bookId) {
            if (!confirm('Do you want to borrow this book?')) return;
            
            this.loading = true;
            try {
                const response = await fetch('<?= site_url('api/borrowings/borrow') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ 
                        book_id: bookId,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    }),
                    credentials: 'include'
                });

                const data = await response.json();
                if (data.success) {
                    alert('Book borrowed successfully! You can view it in "My Borrowings".');
                    window.location.href = '<?= site_url('member/borrowings') ?>';
                } else {
                    alert(data.message || 'Failed to borrow book. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while borrowing the book.');
            } finally {
                this.loading = false;
            }
        },

        async addToWishlist() {
            try {
                const response = await fetch('<?= site_url('api/wishlist/toggle') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ book_id: 1 }),
                    credentials: 'include'
                });

                const data = await response.json();
                if (data.success) {
                    this.wishlistAdded = !this.wishlistAdded;
                    const message = this.wishlistAdded ? 'Added to wishlist!' : 'Removed from wishlist';
                    alert(message);
                } else {
                    alert(data.message || 'Failed to update wishlist.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating wishlist.');
            }
        },

        async shareBook() {
            const bookTitle = '<?= esc($book['title'] ?? 'Unknown Book') ?>';
            const bookUrl = window.location.href;
            
            // Try to use native Web Share API if available
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: bookTitle,
                        text: `Check out "${bookTitle}" in the Library!`,
                        url: bookUrl
                    });
                } catch (error) {
                    console.log('Share cancelled or failed:', error);
                }
            } else {
                // Fallback: Copy to clipboard
                try {
                    await navigator.clipboard.writeText(bookUrl);
                    alert('Book link copied to clipboard! Share it with friends.');
                } catch (error) {
                    alert('Book URL: ' + bookUrl);
                }
            }
        },

        async debugTest() {
            try {
                console.log('Testing API debug endpoint...');
                const response = await fetch('<?= site_url('api/debug/test') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ test: 'debug request' }),
                    credentials: 'include'
                });

                const data = await response.json();
                console.log('Debug Response:', data);
                alert('Debug Info (check console for details):\n' + 
                      `Method: ${data.method}\n` +
                      `Session JWT: ${data.session_data.has_jwt}\n` +
                      `User: ${data.session_data.has_user}\n` +
                      `Logged In: ${data.session_data.is_logged_in}`);
            } catch (error) {
                console.error('Debug Error:', error);
                alert('Debug failed: ' + error.message);
            }
        }
    }
}
</script>
</div>
<?= $this->endSection() ?>
