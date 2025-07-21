<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieDetail extends Model
{
    protected $fillable = ['cinema_name', 'cinema_place', 'period_time', 'show_time', 'movie_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
