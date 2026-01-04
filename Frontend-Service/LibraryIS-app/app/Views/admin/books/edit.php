<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Book<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="mb-8">
    <a href="<?= site_url('admin/books') ?>" class="text-primary-600 hover:text-primary-700 mb-4 inline-flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Books
    </a>
    <h1 class="text-3xl font-display font-bold text-gray-900">Edit Book</h1>
    <p class="text-gray-600 mt-1">Update book information</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <form action="<?= site_url('admin/books/' . $book['id'] . '/update') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Book Title -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Book Title *</label>
            <input type="text" name="title" class="input-field w-full" value="<?= esc($book['title'] ?? '') ?>" placeholder="Enter book title" required>
        </div>

        <!-- Author -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Author *</label>
            <input type="text" name="author" class="input-field w-full" value="<?= esc($book['author'] ?? '') ?>" placeholder="Enter author name" required>
        </div>

        <!-- ISBN -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">ISBN</label>
            <input type="text" name="isbn" class="input-field w-full" value="<?= esc($book['isbn'] ?? '') ?>" placeholder="ISBN number">
        </div>

        <!-- Publisher -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Publisher</label>
            <input type="text" name="publisher" class="input-field w-full" value="<?= esc($book['publisher'] ?? '') ?>" placeholder="Publisher name">
        </div>

        <!-- Publication Year -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Publication Year</label>
            <input type="number" name="publication_year" class="input-field w-full" value="<?= esc($book['publication_year'] ?? '') ?>" placeholder="2024" min="1800" max="2099">
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Category *</label>
            <select name="category" class="input-field w-full" required>
                <option value="">Select category</option>
                <option value="fiction" <?= ($book['category'] ?? '') === 'fiction' ? 'selected' : '' ?>>Fiction</option>
                <option value="non-fiction" <?= ($book['category'] ?? '') === 'non-fiction' ? 'selected' : '' ?>>Non-Fiction</option>
                <option value="mystery" <?= ($book['category'] ?? '') === 'mystery' ? 'selected' : '' ?>>Mystery</option>
                <option value="science-fiction" <?= ($book['category'] ?? '') === 'science-fiction' ? 'selected' : '' ?>>Science Fiction</option>
                <option value="biography" <?= ($book['category'] ?? '') === 'biography' ? 'selected' : '' ?>>Biography</option>
                <option value="history" <?= ($book['category'] ?? '') === 'history' ? 'selected' : '' ?>>History</option>
                <option value="romance" <?= ($book['category'] ?? '') === 'romance' ? 'selected' : '' ?>>Romance</option>
                <option value="children" <?= ($book['category'] ?? '') === 'children' ? 'selected' : '' ?>>Children's</option>
            </select>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
            <textarea name="description" class="input-field w-full" placeholder="Book description" rows="4"><?= esc($book['description'] ?? '') ?></textarea>
        </div>

        <!-- Pages -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Pages</label>
            <input type="number" name="pages" class="input-field w-full" value="<?= esc($book['pages'] ?? '') ?>" placeholder="Number of pages" min="1">
        </div>

        <!-- Language -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Language</label>
            <select name="language" class="input-field w-full">
                <option value="">Select language</option>
                <option value="en" <?= ($book['language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                <option value="id" <?= ($book['language'] ?? '') === 'id' ? 'selected' : '' ?>>Indonesian</option>
                <option value="es" <?= ($book['language'] ?? '') === 'es' ? 'selected' : '' ?>>Spanish</option>
                <option value="fr" <?= ($book['language'] ?? '') === 'fr' ? 'selected' : '' ?>>French</option>
                <option value="de" <?= ($book['language'] ?? '') === 'de' ? 'selected' : '' ?>>German</option>
                <option value="ja" <?= ($book['language'] ?? '') === 'ja' ? 'selected' : '' ?>>Japanese</option>
                <option value="zh" <?= ($book['language'] ?? '') === 'zh' ? 'selected' : '' ?>>Chinese</option>
            </select>
        </div>

        <!-- Quantity -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Quantity *</label>
            <input type="number" name="quantity" class="input-field w-full" value="<?= esc($book['quantity'] ?? '') ?>" placeholder="Number of copies" required min="1">
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-3 py-1 rounded-lg text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200">Update Book</button>
            <a href="<?= site_url('admin/books') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
