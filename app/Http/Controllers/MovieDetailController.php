<?php

namespace App\Http\Controllers;

use App\Models\MovieDetail;
use Illuminate\Http\Request;

class MovieDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cinema_name' => 'required|string|max:255',
            'cinema_place' => 'required|string',
            'period_time' => 'required|string',
            'show_time' => 'required|string|max:255',
            'movie_id' => 'required|integer|exists:movies,id'
        ]);

        $movieDetail = new MovieDetail();

        $movieDetail->cinema_name = $request->cinema_name;
        $movieDetail->cinema_place = $request->cinema_place;
        $movieDetail->period_time = $request->period_time;
        $movieDetail->show_time = $request->show_time;
        $movieDetail->movie_id = $request->movie_id;
        $movieDetail->save();

        return response()->json([
            'message' => 'Movie Details Created Successfully',
            'movieDetails' => $movieDetail
        ]);
    }

    //     public function getAll(Request $request)
    //     {
    //         $movieId = $request->
    //     }
}
