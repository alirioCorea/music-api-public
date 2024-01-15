<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);
        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }else{
            return response()->json([
                'data' => $user
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

    public function followArtist(Request $request, $artistId){
        $user = User::find($request->user()->id);
        
        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $artist = Artist::find($artistId);
        if (!$artist) {
            return response()->json(['message' => 'El artista no existe'], 404);
        }

        // Verificar si el usuario ya sigue al artista
        if ($user->followedArtists()->where('artist_id', $artistId)->exists()) {
            return response()->json(['message' => 'Ya sigues a este artista'], 409);
        }

        $user->followedArtists()->attach($artistId);
        return response()->json([
            'message' => 'Artista seguido correctamente',
            'data' => $user
        ], 201);
    }

    public function getFollowedArtists(Request $request){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $artists = $user->followedArtists()->get();

        return response()->json([
            'data' => $artists
        ], 201);
    }

    public function unfollowArtist(Request $request, $artistId){
        $user = User::find($request->user()->id);
        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }
        $artist = Artist::find($artistId);
        if (!$artist) {
            return response()->json(['message' => 'El artista no existe'], 404);
        }
        $user->followedArtists()->detach($artistId);

        return response()->json([
            'message' => 'Artista dejado de seguir correctamente',
            'data' => $user
        ], 201);
    }

    //Funcion para seguir un album
    public function favoriteAlbum(Request $request, $albumId){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $album = Album::find($albumId);
        if (!$album) {
            return response()->json(['message' => 'El album no existe'], 404);
        }

        // Verificar si el usuario ya sigue al artista
        if ($user->followedAlbums()->where('album_id', $albumId)->exists()) {
            return response()->json(['message' => 'Ya sigues a este album'], 409);
        }

        $user->followedAlbums()->attach($albumId);

        return response()->json([
            'message' => 'Album seguido correctamente',
            'data' => $user
        ], 201);
    }

     //Funcion para obtener los albumes seguidos por el usuario
    public function getFavoriteAlbums(Request $request){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $albums = $user->followedAlbums()->get();

        return response()->json([
            'data' => $albums
        ], 201);
    }

        //Funcion para dejar de seguir un album
    public function unfavoriteAlbum(Request $request, $albumId){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }
        
        $album = Album::find($albumId);

        if (!$album) {
            return response()->json(['message' => 'El album no existe'], 404);
        }

        $user->followedAlbums()->detach($albumId);

        return response()->json([
            'message' => 'Album dejado de seguir correctamente',
            'data' => $user
        ], 201);
    }

    //Fucnion para seguir una cancion
    public function favoriteSong(Request $request, $songId){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $song = Song::find($songId);
        if (!$song) {
            return response()->json(['message' => 'La cancion no existe'], 404);
        }

        // Verificar si el usuario ya sigue al artista
        if ($user->followedSongs()->where('song_id', $songId)->exists()) {
            return response()->json(['message' => 'Ya sigues a esta cancion'], 409);
        }

        $user->followedSongs()->attach($songId);

        return response()->json([
            'message' => 'Cancion seguida correctamente',
            'data' => $user
        ], 201);
    }

    //Funcion para obtener las canciones seguidas por el usuario
    public function getFavoriteSongs(Request $request){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $songs = $user->followedSongs()->get();

        return response()->json([
            'data' => $songs
        ], 201);
    }

    //Funcion para dejar de seguir una cancion
    public function unfavoriteSong(Request $request, $songId){
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }
        
        $song = Song::find($songId);

        if (!$song) {
            return response()->json(['message' => 'La cancion no existe'], 404);
        }

        $user->followedSongs()->detach($songId);

        return response()->json([
            'message' => 'Cancion dejada de seguir correctamente',
            'data' => $user
        ], 201);
    }
}
