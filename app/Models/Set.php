<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{

    public function course(){return $this->belongsTo(Course::class);}
    public function creator(){return $this->belongsTo(User::class, 'creator_id');}
    public function questions(){return $this->hasMany(Question::class);}
    public function accesses(){return $this->hasMany(Access::class);}
}
