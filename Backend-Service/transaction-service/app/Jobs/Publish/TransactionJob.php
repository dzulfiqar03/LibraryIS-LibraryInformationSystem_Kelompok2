<?php

namespace App\Jobs\Publish;

use App\Jobs\Consume\ConsumeMemberDetail;
use App\Jobs\Consume\ConsumeTransaction;
use App\Jobs\Consume\ConsumeTransactionBorrowed;
use App\Models\FinePayment;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $books,
        public string $transactionId,
        public string $id_member
    ) {}

    public function handle()
    {
        // Dispatch ke consume job
        ConsumeTransaction::dispatch($this->books, $this->transactionId)
            ->onQueue(queue: 'book.update');

            $memberstatus = 'active';

        $totalFine = FinePayment::where('id_member', $this->id_member)
            ->where('status', 'unpaid')
            ->sum('fine_amount');

        if ($totalFine > 50000) {
            $memberstatus = 'suspended';
        }

        // Rule 2: Cek Keterlambatan Parah (Misal > 14 hari)
        $hasSevereOverdue = Transaction::where('id_member', $this->id_member)
            ->whereNull('return_date')
            ->where('due_date', '<', now()->subDays(14))
            ->exists();

        if ($hasSevereOverdue) {
            $memberstatus  = 'suspended';
        }

        // Rule 3: Jika denda sudah bayar & buku sudah balik
        if ($totalFine == 0 && !$hasSevereOverdue) {
            $memberstatus  = 'active';
        }

        $borrowedCount = Transaction::where('id_member', $this->id_member)
            ->count();


        ConsumeMemberDetail::dispatch($this->books, $this->transactionId, $this->id_member, $memberstatus, $borrowedCount, $totalFine)
            ->onQueue('memberDetail.update');
    }
}
