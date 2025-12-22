<?php

namespace App\Jobs\Consume;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use App\Models\BookDetail;

class ConsumeTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $books;
    public string $transactionId;

    public function __construct(array $books, string $transactionId)
    {
        $this->books = $books;
        $this->transactionId = $transactionId;
    }

    public function handle()
    {
        foreach ($this->books as $b) {
            BookDetail::where('id_book', $b['id_book'])->update([
                'status' => $b['status']
            ]);
        }

        Log::info("Books updated for transaction {$this->transactionId}");
    }
}
