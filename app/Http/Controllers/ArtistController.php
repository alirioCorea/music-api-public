<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Genre;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::with('genres')->get();

        return response()->json([
            'message' => 'Lista de artistas',
            'artists' => $artists
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|max:2048', 
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id'
        ]);

        $artist = Artist::create($validatedData);
        $artist->genres()->sync($validatedData['genres']);
        
        // Cargar imagen si está presente
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/artists', 'public');
            $artist->image = $path;
            $artist->save();
        }


        return response()->json([
            'message' => 'Artista creado exitosamente',
            'artist' => $artist
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artist = Artist::find($id);
        
        $genres = $artist->genres;

        if (!$artist) {
            return response()->json([
                'message' => 'Artista no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Artista encontrado',
            'artist' => $artist
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getRelatedArtists($artistId){
        $artist = Artist::find($artistId);

        if (!$artist) {
            return response()->json([
                'message' => 'Artista no encontrado'
            ], 404);
        }
        $genres = $artist->genres;

        $relatedArtists = Artist::whereHas('genres', function($query) use ($genres){
            $query->whereIn('genres.id', $genres->pluck('id'));
        })->where('id', '!=', $artistId)->get();

        return response()->json([
            'message' => 'Artistas relacionados',
            'artists' => $relatedArtists
        ], 200);
    }

}
