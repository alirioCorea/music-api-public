<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Song extends Model { 
    use HasFactory; 
    protected $fillable = [ 
        'title', 
        'duration', 
        'album_id', 
        'play_count' 
    ]; 
    
    public function album() { 
        return $this->belongsTo(Album::class); 
    } 

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)
                    ->withPivot('user_id', 'added_on')
                    ->withTimestamps();
    }

    public function followedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_album');
    }
}