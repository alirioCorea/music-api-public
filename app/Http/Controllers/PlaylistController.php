<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Http\Requests\PlaylistRequest;
use App\Models\Song;


class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::with('songs')->get();

        return response()->json([
            'message' => 'Lista de playlists',
            'playlists' => $playlists
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaylistRequest $request)
    {
        $validatedData = $request->validated();

        $playlist = Playlist::create($validatedData);

        return response()->json([
            'message' => 'Playlist creada exitosamente',
            'playlist' => $playlist
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    // Activar playlist
    public function enable($id){
        $user = auth()->user();
        $userId = $user->id;
        $playlist = Playlist::onlyTrashed()->where('id', $id)->where('user_id', $userId)->first();

        if (!$playlist) {
            return response()->json(['message' => 'Playlist no encontrada'], 404);
        }

        // Si la playlist está en la papelera, la restauramos
        if ($playlist->trashed()) {
            $playlist->restore();
            return response()->json(['message' => 'Playlist restaurada'], 200);
        }

        return response()->json([
            'message' => 'Playlist activada exitosamente',
            'playlist' => $playlist
        ], 200);
    }

    // Desactivar playlist
    public function disable($id){
        $user = auth()->user();
        $userId = $user->id;
        // Buscamos la playlist por id y por el id del usuario
        $playlist = Playlist::where('id', $id)->where('user_id', $userId)->first();

  
        if (!$playlist) {
            return response()->json(['message' => 'Playlist no encontrada'], 404);
        }

        $playlist->delete();

        return response()->json([
            'message' => 'Playlist desactivada exitosamente',
            'playlist' => $playlist
        ], 200);
    }

    // Obtener playlists del usuario
    public function myPlaylists(){
        $user = auth()->user();
        $userId = $user->id;
        $playlists = Playlist::where('user_id', $userId)->get();

        return response()->json([
            'message' => 'Lista de playlists',
            'playlists' => $playlists
        ], 200);
    }

    // Obtener playlists eliminadas
    public function getDeletedPlaylists(){
        $user = auth()->user();
        $userId = $user->id;
        $playlists = Playlist::onlyTrashed()->where('user_id', $userId)->get();

        return response()->json([
            'message' => 'Lista de playlists',
            'playlists' => $playlists
        ], 200);
    }


    // Agregar canción a playlist
    public function addSongToPlaylist(Request $request, $id){
        $user = auth()->user();
        $userId = $user->id;
        $playlist = Playlist::where('id', $id)->first();

        if (!$playlist) {
            return response()->json(['message' => 'Playlist no encontrada'], 404);
        }

        $songId = $request->song_id;

        // Verificar si la canción ya existe en la playlist
        if ($playlist->songs()->where('song_id', $songId)->exists()) {
            return response()->json(['message' => 'La canción ya está en la playlist'], 409);
        }

        $songId = $request->song_id;
        $song = Song::find($songId);

        if (!$song) {
            return response()->json(['message' => 'Canción no encontrada'], 404);
        }

        $playlist->songs()->attach($songId, [
            'user_id' => $userId,
            'added_on' => now()
        ]);

        $playlist->increment('song_count');

        return response()->json([
            'message' => 'Canción agregada a la playlist',
            'playlist' => $playlist
        ], 200);
    }

}
