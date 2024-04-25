<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['nom'];

    // A game may be associated with many rooms
    public function rooms() {
        return $this->hasMany(Room::class, 'gameid');
    }

    // A game can have multiple scores from different users
    public function scores() {
        return $this->hasMany(Score::class, 'gameid');
    }
}
