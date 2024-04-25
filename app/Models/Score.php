<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['userid', 'gameid', 'score'];

    // Each score entry belongs to a user
    public function user() {
        return $this->belongsTo(User::class, 'userid');
    }

    // Each score entry is associated with a game
    public function game() {
        return $this->belongsTo(Game::class, 'gameid');
    }
}