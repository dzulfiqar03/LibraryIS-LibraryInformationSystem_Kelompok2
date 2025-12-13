<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $fillable = [
        'id_book'
    ];

    public function book_detail()
    {
        return $this->belongsTo(Book::class, 'id_book', 'id');
    }
}
