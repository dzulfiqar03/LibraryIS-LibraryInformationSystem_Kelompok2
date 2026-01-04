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
use App\Models\BookSnapshot;

class ConsumeBookSnaphot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $books;
    public string $status, $method;

    public function __construct(array $books, string $status, string $method)
    {
        $this->books = $books;
        $this->status = $status;
        $this->method = $method;
    }

    public function handle()
    {
        if ($this->method === 'delete') {
            foreach ($this->books as $b) {
                BookSnapshot::where('id_book', $b['id_book'])
                    ->where('status', $this->status)
                    ->delete();
            }

        } else {

        foreach ($this->books as $b) {
            BookSnapshot::updateOrInsert([
                'id_book' => $b['id_book'],
                'status' => $this->status


            ]);
        }
    }
    }

}
