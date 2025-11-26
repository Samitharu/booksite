<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookSale extends Model
{
    protected $fillable = [
        'book_id',
        'quantity',
        'price',
        'total',
        'user_id',
        'order_id',
        'invoice_id',
    ];

    public function book()
{
    return $this->belongsTo(Book::class, 'book_id');
}

}
