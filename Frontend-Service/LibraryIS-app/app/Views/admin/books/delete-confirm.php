<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Delete Book<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">Delete Book</h1>
    <p class="text-gray-600 mt-1">This action cannot be undone</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="bg-danger-50 border border-danger-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-danger-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2m0 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-bold text-danger-900">Warning</h3>
                <p class="text-sm text-danger-800 mt-1">You are about to permanently delete this book from the library. This action cannot be undone.</p>
            </div>
        </div>
    </div>

    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-bold text-gray-900 mb-2"><?= esc($book['title'] ?? 'Unknown Book') ?></h3>
        <p class="text-sm text-gray-600">by <?= esc($book['author'] ?? 'Unknown Author') ?></p>
        <p class="text-sm text-gray-600">ISBN: <?= esc($book['isbn'] ?? 'N/A') ?></p>
        <p class="text-sm text-gray-600">Quantity: <?= esc($book['quantity'] ?? 0) ?> copies</p>
    </div>

    <form action="<?= site_url('admin/books/' . $book['id'] . '/delete') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="flex gap-3">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you absolutely sure you want to delete this book?')">
                Yes, Delete This Book
            </button>
            <a href="<?= site_url('admin/books/' . $book['id']) ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
