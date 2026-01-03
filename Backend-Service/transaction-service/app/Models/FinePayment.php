<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FinePayment extends Model
{
    use HasUuids;

    protected $fillable = [
        'id_transaction',
        'id_member',
        'fine_amount',
        'paid_amount',
        'status',
        'description',
        'paid_date',
        'payment_method'
    ];

    protected $casts = [
        'fine_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_date' => 'datetime'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->fine_amount - $this->paid_amount;
    }

    public function isFullyPaid()
    {
        return $this->status === 'paid';
    }

    public function markAsPaid($amount, $method = null)
    {
        $this->paid_amount += $amount;

        if ($this->paid_amount >= $this->fine_amount) {
            $this->status = 'paid';
            $this->paid_date = now();
        } else {
            $this->status = 'partial';
        }

        if ($method) {
            $this->payment_method = $method;
        }

        $this->save();
    }
}
