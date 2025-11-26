<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author_id', 'publisher_id','category_id', 'price',
        'discount_percent', 'stock', 'cover_image', 'description','images'
    ];

    protected $casts = [
    'images' => 'array',
];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price * (1 - $this->discount_percent / 100);
        }
        return $this->price;
    }

    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }
}
