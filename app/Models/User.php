<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'username',
        'birth_date',
        'gender',
        'country',
        'postal_code',
        'user_type',
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function followedArtists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function followedAlbums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function followedSongs()
    {
        return $this->belongsToMany(Song::class);
    }
}
