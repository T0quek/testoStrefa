<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function sets(){return $this->hasMany(Set::class);}
}
