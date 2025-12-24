<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Book Management<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Book Management</h1>
            <p class="text-gray-600 mt-1">Manage all books in the library</p>
        </div>
        <a href="<?= site_url('admin/books/create') ?>" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Book
        </a>
    </div>
</div>

<!-- Books Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ISBN</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?= esc($book['title'] ?? 'N/A') ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= esc($book['author'] ?? 'N/A') ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= esc($book['isbn'] ?? 'N/A') ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= esc($book['category'] ?? 'N/A') ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?= esc($book['quantity'] ?? 0) ?></td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="<?= site_url('admin/books/' . $book['id']) ?>" class="text-primary-600 hover:text-primary-700 font-medium">View</a>
                            <a href="<?= site_url('admin/books/' . $book['id'] . '/edit') ?>" class="text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                            <a href="<?= site_url('admin/books/' . $book['id'] . '/delete') ?>" class="text-danger-600 hover:text-danger-700 font-medium" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No books found. <a href="<?= site_url('admin/books/create') ?>" class="text-primary-600 hover:underline">Add a book</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
