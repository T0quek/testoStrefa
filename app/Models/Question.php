<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'data' => 'array', // Automatyczne parsowanie JSON
    ];

    public function set(){return $this->belongsTo(Set::class);}
    public function questionReports(){return $this->hasMany(QuestionReport::class);}
    public function previousQuestion(){return $this->belongsTo(Question::class, 'previous_question_id');}
}
