<?= $this->extend('layouts/member') ?>
<?= $this->section('page_content') ?>

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Denda Keterlambatan</h1>
        <p class="text-sm text-gray-500 mt-1">
            Buku yang terlambat dikembalikan (Rp 5.000 / hari)
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr class="text-left text-gray-600 font-semibold">
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Jatuh Tempo</th>
                        <th class="px-6 py-4">Overdue</th>
                        <th class="px-6 py-4">Denda</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                <?php
                    $fineList = $fines['fines'] ?? [];
                ?>

                <?php if (!empty($fineList)): ?>
                    <?php foreach ($fineList as $fine): ?>
                        <?php
                            $dueDate = strtotime($fine['due_date']);
                            $daysOverdue = max(0, floor((time() - $dueDate) / 86400));
                            $totalFine = $daysOverdue * 5000;
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?= esc($fine['book_title'] ?? '-') ?>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                <?= date('d M Y', $dueDate) ?>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    <?= $daysOverdue ?> hari
                                </span>
                            </td>

                            <td class="px-6 py-4 font-semibold text-red-600">
                                Rp <?= number_format($totalFine, 0, ',', '.') ?>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    Belum Dibayar
                                </span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada denda 🎉
                        </td>
                    </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
