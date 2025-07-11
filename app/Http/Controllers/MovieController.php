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
}
