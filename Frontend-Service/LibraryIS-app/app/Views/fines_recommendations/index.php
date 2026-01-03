<?= $this->extend('layouts/member') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-blue-800">Denda & Rekomendasi</h1>
    
    <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <p><?= esc($error) ?></p>
    </div>
    <?php endif; ?>

    <!-- Fines Section -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Denda Keterlambatan</h2>
            <?php if ($fines['total_unpaid_fine'] > 0): ?>
            <div class="bg-red-100 px-4 py-2 rounded-lg">
                <span class="text-red-800 font-semibold">Total Denda: Rp <?= number_format($fines['total_unpaid_fine']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (empty($fines['fines'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <p class="font-semibold">🎉 Tidak ada denda keterlambatan!</p>
            <p>Anda tidak memiliki buku yang terlambat dikembalikan.</p>
        </div>
        <?php else: ?>
        <div class="grid gap-4">
            <?php foreach ($fines['fines'] as $fine): ?>
            <div class="bg-white border border-red-200 rounded-lg p-6 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold text-lg text-gray-800">ID Buku: <?= esc($fine['transaction']['id_book']) ?></h3>
                        <p class="text-gray-600">Tanggal Pinjam: <?= date('d M Y', strtotime($fine['transaction']['borrow_date'])) ?></p>
                        <p class="text-gray-600">Tanggal Jatuh Tempo: <?= date('d M Y', strtotime($fine['transaction']['due_date'])) ?></p>
                        <p class="text-red-600 font-semibold">Terlambat: <?= $fine['days_overdue'] ?> hari</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-red-600">Rp <?= number_format($fine['fine_amount']) ?></p>
                        <?php if ($fine['existing_fine'] && $fine['existing_fine']['status'] === 'paid'): ?>
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Dibayar</span>
                        <?php elseif ($fine['can_pay']): ?>
                        <button onclick="payFine('<?= esc($fine['existing_fine']['id'] ?? '') ?>')" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">
                            Bayar Denda
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($fine['existing_fine']): ?>
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600">
                        Status: 
                        <span class="<?= $fine['existing_fine']['status'] === 'paid' ? 'text-green-600' : 'text-red-600' ?>">
                            <?= ucfirst($fine['existing_fine']['status']) ?>
                        </span>
                    </p>
                    <?php if ($fine['existing_fine']['paid_at']): ?>
                    <p class="text-sm text-gray-600">Dibayar pada: <?= date('d M Y H:i', strtotime($fine['existing_fine']['paid_at'])) ?></p>
                    <p class="text-sm text-gray-600">Metode Pembayaran: <?= ucfirst($fine['existing_fine']['payment_method']) ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Recommendations Section -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Rekomendasi Buku</h2>
            <button onclick="generateRecommendations()" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                🔄 Perbarui Rekomendasi
            </button>
        </div>

        <?php if (empty($recommendations)): ?>
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <p class="font-semibold">📚 Belum ada rekomendasi</p>
            <p>Klik tombol "Perbarui Rekomendasi" untuk mendapatkan saran buku yang sesuai untuk Anda!</p>
        </div>
        <?php else: ?>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($recommendations as $rec): ?>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="mb-4">
                    <?php if (isset($rec['book'])): ?>
                    <h3 class="font-semibold text-lg text-gray-800 mb-2"><?= esc($rec['book']['title']) ?></h3>
                    <p class="text-gray-600 mb-1">Penulis: <?= esc($rec['book']['author']) ?></p>
                    <p class="text-gray-600 mb-1">Kategori: <?= esc($rec['book']['category']) ?></p>
                    <p class="text-gray-600 mb-1">Tahun: <?= esc($rec['book']['publication_year']) ?></p>
                    <?php else: ?>
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">ID Buku: <?= esc($rec['id_book']) ?></h3>
                    <p class="text-gray-600 mb-1">Detail buku tidak tersedia</p>
                    <?php endif; ?>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">Score:</span>
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: <?= min(100, ($rec['score'] / 10) * 100) ?>%"></div>
                            </div>
                            <span class="text-sm font-semibold"><?= number_format($rec['score'], 1) ?>/10</span>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-600 mb-3"><?= esc($rec['reason']) ?></p>
                    
                    <div class="flex justify-between items-center">
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                            <?= ucfirst(str_replace('_', ' ', $rec['type'])) ?>
                        </span>
                        
                        <button onclick="markAsViewed('<?= esc($rec['id']) ?>')" 
                                class="text-xs text-gray-500 hover:text-gray-700">
                            Tandai Dilihat
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
        <div class="mb-4">
            <label class="block mb-2">
                <input type="radio" name="payment_method" value="cash" checked class="mr-2">
                Tunai
            </label>
            <label class="block mb-2">
                <input type="radio" name="payment_method" value="transfer" class="mr-2">
                Transfer Bank
            </label>
            <label class="block mb-2">
                <input type="radio" name="payment_method" value="credit_card" class="mr-2">
                Kartu Kredit
            </label>
        </div>
        <div class="flex justify-end">
            <button onclick="closePaymentModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                Batal
            </button>
            <button onclick="confirmPayment()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Bayar
            </button>
        </div>
    </div>
</div>

<script>
let currentFineId = null;

function payFine(fineId) {
    currentFineId = fineId;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    currentFineId = null;
}

function confirmPayment() {
    if (!currentFineId) return;
    
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    fetch('<?= site_url('fines-recommendations/pay-fine') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            fine_id: currentFineId,
            payment_method: selectedPaymentMethod
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pembayaran');
    });
    
    closePaymentModal();
}

function generateRecommendations() {
    fetch('<?= site_url('fines-recommendations/generate-recommendations') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat membuat rekomendasi');
    });
}

function markAsViewed(recommendationId) {
    fetch('<?= site_url('fines-recommendations/mark-viewed') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            recommendation_id: recommendationId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Just fade out the recommendation card
            event.target.closest('.bg-white').style.opacity = '0.5';
            event.target.textContent = 'Dilihat';
            event.target.disabled = true;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

<?= $this->endSection() ?>