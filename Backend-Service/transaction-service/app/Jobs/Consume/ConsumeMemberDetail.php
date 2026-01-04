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
use App\Models\MemberDetail;

class ConsumeMemberDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $books;
    public string $transactionId;
    public string $id_member;
    public string $member_status;
    public $borrowedCount;
    public $totalFine;


    public function __construct(array $books, string $transactionId, string $id_member, string $member_status, $borrowedCount, $totalFine)
    {
        $this->books = $books;
        $this->transactionId = $transactionId;
        $this->id_member = $id_member;
        $this->member_status = $member_status;
        $this->borrowedCount = $borrowedCount;
        $this->totalFine = $totalFine;
    }


    public function handle()
    {

        MemberDetail::where('id_user', $this->id_member)->updateOrCreate([
            'id_user' => $this->id_member,
            'membership_status' => $this->member_status,
            'borrowing_count' => $this->borrowedCount,
            'total_fine' => $this->totalFine
        ]);


        Log::info("Books updated for transaction {$this->transactionId}");
    }
}
