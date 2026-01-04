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
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">📚 Books</h2>
    </div>

    <div class="overflow-x-auto">
        <table id="booksTable"
               class="w-full text-sm border-separate border-spacing-y-3">
            <thead>
                <tr class="text-xs uppercase text-gray-400">
                    <th class="px-5 py-3 text-left">Book</th>
                    <th class="px-5 py-3 text-left">Author</th>
                    <th class="px-5 py-3 text-left">ISBN</th>
                    <th class="px-5 py-3 text-left">Category</th>
                    <th class="px-5 py-3 text-left">Stock</th>
                    <th class="px-5 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($books as $book): ?>
                <tr class="group bg-white shadow-sm hover:shadow-lg transition-all duration-200 rounded-xl">
                    <!-- Book -->
                    <td class="px-5 py-4 rounded-l-xl">
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-800">
                                <?= esc($book['title']) ?>
                            </span>
                            <span class="text-xs text-gray-400">
                                ID #<?= esc($book['id']) ?>
                            </span>
                        </div>
                    </td>

                    <!-- Author -->
                    <td class="px-5 py-4 text-gray-600">
                        <?= esc($book['author']) ?>
                    </td>

                    <!-- ISBN -->
                    <td class="px-5 py-4 text-gray-500">
                        <?= esc($book['isbn']) ?>
                    </td>

                    <!-- Category -->
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center rounded-full
                                     bg-indigo-50 text-indigo-600
                                     px-3 py-1 text-xs font-medium">
                            <?= esc($book['category']) ?>
                        </span>
                    </td>

                    <!-- Stock -->
                    <td class="px-5 py-4">
                        <?php if ($book['quantity'] <= 0): ?>
                            <span class="text-red-600 font-semibold">Out</span>
                        <?php elseif ($book['quantity'] < 5): ?>
                            <span class="text-amber-600 font-semibold">Low (<?= $book['quantity'] ?>)</span>
                        <?php else: ?>
                            <span class="text-emerald-600 font-semibold"><?= $book['quantity'] ?></span>
                        <?php endif; ?>
                    </td>

                    <!-- Action -->
                    <td class="px-5 py-4 rounded-r-xl">
                        <div class="flex justify-end gap-2  transition">
                            <a href="<?= site_url('admin/books/'.$book['id']) ?>"
                               class="px-3 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200">
                               View
                            </a>
                            <a href="<?= site_url('admin/books/'.$book['id'].'/edit') ?>"
                               class="px-3 py-1 rounded-lg text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                               Edit
                            </a>
                            <a href="<?= site_url('admin/books/'.$book['id'].'/delete') ?>"
                               class="px-3 py-1 rounded-lg text-xs bg-red-100 text-red-700 hover:bg-red-200"
                               onclick="return confirm('Delete this book?')">
                               Delete
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
.dataTables_filter input {
    border: 1px solid #e5e7eb;
    border-radius: .75rem;
    padding: .45rem .75rem;
}
.dt-btn {
    background: #4f46e5 !important;
    color: white !important;
    border-radius: .75rem !important;
    padding: .4rem .9rem !important;
    font-size: .75rem;
}
.dt-btn:hover {
    background: #4338ca !important;
}
</style>


<script>
$(document).ready(function () {
    $('#booksTable').DataTable({
        dom: '<"flex justify-between items-center mb-4"Bf>rt<"flex justify-between items-center mt-4"ip>',
        pageLength: 10,
        ordering: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: 5 } // Actions
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'dt-btn'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                className: 'dt-btn'
            },
            {
                extend: 'print',
                text: 'Print',
                className: 'dt-btn'
            }
        ],
        language: {
            search: '',
            searchPlaceholder: 'Search books...',
            info: 'Showing _START_ to _END_ of _TOTAL_ books',
            paginate: {
                next: 'Next',
                previous: 'Prev'
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
