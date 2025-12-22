<?php

namespace App\Jobs\Publish;

use App\Jobs\Consume\ConsumeTransaction;
use App\Jobs\Consume\ConsumeTransactionBorrowed;
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
        public string $transactionId
    ) {}

    public function handle()
    {
        // Dispatch ke consume job
        ConsumeTransaction::dispatch($this->books, $this->transactionId)
            ->onQueue('book.update');
    }
}
