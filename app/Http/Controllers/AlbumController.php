<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Requests\AlbumRequest;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lista de albums con sus canciones
        $albums = Album::with('songs')->get();

        return response()->json([
            'message' => 'Lista de albums',
            'albums' => $albums
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $validatedData = $request->validated();

        $album = Album::create($validatedData);

         // Manejo de la imagen
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('images/albums', 'public');
            $album->cover_image = $path;
        }

        $album->save();

        return response()->json([
            'message' => 'Album creado exitosamente',
            'album' => $album
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json([
                'message' => 'Album no encontrado',
            ], 404);
        }
        $songs = $album->songs;
        return response()->json([
            'message' => 'Album encontrado',
            'album' => $album
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
}
