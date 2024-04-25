<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['nom', 'userid', 'type', 'password', 'gameid'];

    // A room belongs to a user
    public function user() {
        return $this->belongsTo(User::class, 'userid');
    }

    // A room may be linked to a specific game
    public function game() {
        return $this->belongsTo(Game::class, 'gameid');
    }

    // A room can have multiple scores
    public function scores() {
      return $this->hasMany(Score::class, 'roomid');
    }
}
