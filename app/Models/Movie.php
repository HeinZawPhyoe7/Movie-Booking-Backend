<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'description', 'images', 'genre'];

    public function movie_details()
    {
        return $this->hasMany(MovieDetail::class);
    }
}
