<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Book Details<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="mb-8">
    <a href="<?= site_url('admin/books') ?>" class="text-primary-600 hover:text-primary-700 mb-4 inline-flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Books
    </a>
    <h1 class="text-3xl font-display font-bold text-gray-900"><?= esc($book['title'] ?? 'Book Details') ?></h1>
    <p class="text-gray-600 mt-1">Book Information and Details</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Author</p>
                <p class="text-lg text-gray-900"><?= esc($book['author'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">ISBN</p>
                <p class="text-lg text-gray-900"><?= esc($book['isbn'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Publisher</p>
                <p class="text-lg text-gray-900"><?= esc($book['publisher'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Publication Year</p>
                <p class="text-lg text-gray-900"><?= esc($book['publication_year'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Category</p>
                <p class="text-lg text-gray-900"><?= esc($book['category'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Language</p>
                <p class="text-lg text-gray-900"><?= esc($book['language'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Pages</p>
                <p class="text-lg text-gray-900"><?= esc($book['pages'] ?? 'N/A') ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Description</p>
                <p class="text-gray-700 mt-2"><?= esc($book['description'] ?? 'No description available') ?></p>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Inventory</h3>
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-gray-600">Available Copies</p>
                <p class="text-3xl font-bold text-blue-600"><?= esc($book['quantity'] ?? 0) ?></p>
            </div>

            <div class="space-y-2">
                <a href="<?= site_url('admin/books/' . $book['id'] . '/edit') ?>" class="px-3 py-1 rounded-lg text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                    Edit Book</a>
                <a href="<?= site_url('admin/books/' . $book['id'] . '/delete') ?>" class="px-3 py-1 rounded-lg text-xs bg-red-100 text-red-700 hover:bg-red-200">Delete Book</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>