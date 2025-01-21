<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    public function user(){return $this->belongsTo(User::class);}
    public function creator(){return $this->belongsTo(User::class, 'creator_id');}
    public function set(){return $this->belongsTo(Set::class);}
}
