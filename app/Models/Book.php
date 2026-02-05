<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id','isbn','title','author','publisher','year','stock'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
