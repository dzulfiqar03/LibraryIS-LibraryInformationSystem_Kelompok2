<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Admin Dashboard<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">Admin Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome, <?= esc($user['name'] ?? 'Administrator') ?></p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Books Management Card -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Book Management</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">📚</p>
            </div>
            <div class="text-right">
                <a href="<?= site_url('admin/books') ?>" class="btn btn-primary text-sm">
                    Manage Books
                </a>
            </div>
        </div>
    </div>

    <!-- Add New Book Card -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Add New Book</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">➕</p>
            </div>
            <div class="text-right">
                <a href="<?= site_url('admin/books/create') ?>" class="btn btn-success text-sm">
                    Add Book
                </a>
            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">System Settings</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">⚙️</p>
            </div>
            <div class="text-right">
                <button class="btn btn-outline text-sm">Settings</button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
    <div class="space-y-2">
        <a href="<?= site_url('admin/books/create') ?>" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
            <span class="mr-3">➕</span>
            <span>Add a new book to the library</span>
        </a>
        <a href="<?= site_url('admin/books') ?>" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
            <span class="mr-3">📖</span>
            <span>View all books and manage inventory</span>
        </a>
    </div>
</div>
<?= $this->endSection() ?>
