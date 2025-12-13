<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title'
    ];

    public function book_detail()
    {
        return $this->hasMany(BookDetail::class, 'id_book', 'id');
    }
}
