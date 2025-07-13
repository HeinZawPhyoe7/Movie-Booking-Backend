<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|string',
            'genre' => 'required|string|max:255',
        ]);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $base64String = $request->images;

        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $cleanedBase64 = substr($base64String, strpos($base64String, ',') + 1);
            $imageType = strtolower($type[1]);

            $decodedImage = base64_decode($cleanedBase64);

            if ($decodedImage === false) {
                return response()->json(['message' => 'Base64 decode failed'], 400);
            }

            $fileName = uniqid() . '.' . $imageType;
            Storage::disk('public')->put("images/{$fileName}", $decodedImage);

            $movie->images = $cleanedBase64;
        }
        $movie->genre = $request->genre;
        $movie->save();

        return response()->json([
            'message' => 'success',
            'movie' => $movie
        ]);
    }

    public function getALL()
    {
        $movies = Movie::all();

        return response()->json([
            'message' => 'success',
            'movies' => $movies
        ]);
    }

    public function updateMovie(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:movies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|string',
            'genre' => 'required|string|max:255',
        ]);

        $movie = Movie::findOrFail($request->id);

        $movie->title = $request->title;
        $movie->description = $request->description;
        $base64String = $request->images;

        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $cleanedBase64 = substr($base64String, strpos($base64String, ',') + 1);
            $imageType = strtolower($type[1]);

            $decodedImage = base64_decode($cleanedBase64);

            if ($decodedImage === false) {
                return response()->json(['message' => 'Base64 decode failed'], 400);
            }

            $fileName = uniqid() . '.' . $imageType;
            Storage::disk('public')->put("images/{$fileName}", $decodedImage);

            $movie->images = $cleanedBase64;
        }

        $movie->genre = $request->genre;
        $movie->save();

        return response()->json([
            'message' => 'Movie updated successfully',
            'movie' => $movie
        ]);
    }

    public function deleteMovie(Request $request)
    {

        $request->validate([
            'movieId' => 'required|integer|exists:movies,id',
        ]);

        $movie = Movie::find($request->movieId);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        $movie->delete();

        return response()->json([
            'message' => 'Movie deleted successfully',
            'movies' => $movie,
            'code' => 200
        ], 200);
    }
}
