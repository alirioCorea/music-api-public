<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::all();
        return response()->json([
            "message" => "Lista de canciones",
            'data' => $songs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SongRequest $request)
    {
        $song = Song::create($request->validated());
        return response()->json([
            'message' => 'Cancion creada correctamente',
            'data' => $song
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $song = Song::find($id);
        if (!$song) {
            return response()->json(['message' => 'La cancion no existe'], 404);
        }else{
            return response()->json([
                'data' => $song
            ]);
        }
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

    public function playSong($id){
        $song = Song::find($id);
        if (!$song) {
            return response()->json(['message' => 'Canción no encontrada'], 404);
        }
        // Incrementar el contador de reproducciones
        $song->increment('play_count');

        return response()->json([
            'message' => 'Reproducción registrada',
            'data' => $song
        ], 200);
    }
}
