<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $fillable = [
        'id_book',
        'authors',
        'isbn',
        'publisher',
        'publication_year',
        'category',
        'description',
        'pages',
        'quantity',
        'languages',
        'url_cover',
        'url_ebook',
        'status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book', 'id');
    }
}
