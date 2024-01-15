 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group([ 'prefix'=>'auth'], function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [UserController::class, 'store']);
    Route::middleware(['auth:api', ])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::group([ 'prefix'=>'user','middleware'=>['auth:api'] ], function(){
    Route::get('/profile/{id}', [UserController::class,'show']);
    Route::get('/index', [UserController::class,'index']);
    Route::get('artists/follow/{id}', [UserController::class,'followArtist']);
    Route::get('artists/unfollow/{id}', [UserController::class,'unfollowArtist']);
    Route::get('artists/followedArtists', [UserController::class,'getFollowedArtists']);
    Route::get('albums/favorite/{id}', [UserController::class,'favoriteAlbum']);
    Route::get('albums/unfavorite/{id}', [UserController::class,'unfavoriteAlbum']);
    Route::get('albums/favoriteAlbums', [UserController::class,'getFavoriteAlbums']);
    Route::get('songs/favorite/{id}', [UserController::class,'favoriteSong']);
    Route::get('songs/unfavorite/{id}', [UserController::class,'unfavoriteSong']);
    Route::get('songs/favoriteSongs', [UserController::class,'getFavoriteSongs']);
});

Route::group([ 'prefix'=>'subscription','middleware'=>['auth:api'] ], function(){
    Route::post('/create', [SubscriptionController::class,'store']);
    Route::get('/show/{id}', [SubscriptionController::class,'show']);
});

Route::group([ 'prefix'=>'playlist','middleware'=>['auth:api'] ], function(){
    Route::get('/index', [PlaylistController::class,'index']);
    Route::post('/create', [PlaylistController::class,'store']);
    Route::get('/show/{id}', [PlaylistController::class,'show']);
    Route::get('/enable/{id}', [PlaylistController::class,'enable']);
    Route::get('/disable/{id}', [PlaylistController::class,'disable']);
    Route::get('/deletedPlaylists', [PlaylistController::class,'getDeletedPlaylists']);
    Route::get('/myPlaylists', [PlaylistController::class,'myPlaylists']);
    Route::post('/{id}/songs', [PlaylistController::class,'addSongToPlaylist']);
});

Route::group([ 'prefix'=>'artist','middleware'=>['auth:api'] ], function(){
    Route::get('/index', [ArtistController::class,'index']);
    Route::post('/create', [ArtistController::class,'store']);
    Route::get('/show/{id}', [ArtistController::class,'show']);
    Route::get('/relatedArtists/{id}', [ArtistController::class,'getRelatedArtists']);
});

Route::group([ 'prefix'=>'album','middleware'=>['auth:api'] ], function(){
    Route::get('/index', [AlbumController::class,'index']);
    Route::post('/create', [AlbumController::class,'store']);
    Route::get('/show/{id}', [AlbumController::class,'show']);
});

Route::group([ 'prefix'=>'song','middleware'=>['auth:api'] ], function(){
    Route::get('/index', [SongController::class,'index']);
    Route::post('/create', [SongController::class,'store']);
    Route::get('/show/{id}', [SongController::class,'show']);
    Route::get('/play/{id}', [SongController::class,'playSong']);
});

Route::group([ 'prefix'=>'genre','middleware'=>['auth:api'] ], function(){
    Route::get('/index', [GenreController::class,'index']);
    Route::post('/create', [GenreController::class,'store']);
    Route::get('/show/{id}', [GenreController::class,'show']);
});
