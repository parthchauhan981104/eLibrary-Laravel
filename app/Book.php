<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function users()
    {
       return $this->belongsToMany(User::class, 'book_user')->withTimestamps();
    }

    public function author()
    {
       return $this->belongsTo(Author::class);
    }

    public function categories()
    {
       return $this->belongsToMany(Category::class, 'book_category')->withTimestamps();
    }

}
