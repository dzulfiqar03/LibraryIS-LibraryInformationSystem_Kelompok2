<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'id_member',
        'id_book',
        'transaction_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
        'fine_amount' => 'decimal:2'
    ];

    // Relasi dengan member (dari member-service)
    public function member()
    {
        // Ini akan menggunakan API call atau service integration
    }

    // Relasi dengan book (dari book-service)
    public function book()
    {
        // Ini akan menggunakan API call atau service integration
    }

    // Relasi dengan transaction details
    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction');
    }

        public function fine_payment()
    {
        return $this->hasOne(FinePayment::class, 'id_transaction');
    }

}
