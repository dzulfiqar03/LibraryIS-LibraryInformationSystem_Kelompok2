<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'id_transaction',
        'id_book',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }
}
