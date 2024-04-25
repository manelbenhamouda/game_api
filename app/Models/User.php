<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['nom', 'password'];
    
    // Each user may have multiple rooms
    public function rooms() {
        return $this->hasMany(Room::class, 'userid');
    }

    // Each user can have multiple scores across different games
    public function scores() {
        return $this->hasMany(Score::class, 'userid');
    }
}
