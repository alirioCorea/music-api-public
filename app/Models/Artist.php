<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'image'
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
