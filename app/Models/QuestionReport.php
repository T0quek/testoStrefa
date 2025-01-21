<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionReport extends Model
{
    public function question(){return $this->belongsTo(Question::class);}

    public function user(){return $this->belongsTo(User::class);}
}