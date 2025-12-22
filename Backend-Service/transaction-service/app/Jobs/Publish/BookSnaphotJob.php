<?php

namespace App\Jobs\Publish;

use App\Jobs\Consume\ConsumeBookSnaphot;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class BookSnaphotJob implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $books,
        public string $status, 
        public string $method
    ) {}

    public function handle()
    {
        // Dispatch ke consume job
        ConsumeBookSnaphot::dispatch($this->books, $this->status, $this->method)
            ->onQueue('snapshot.book.update');
    }
}
