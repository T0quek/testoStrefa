<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    use HasFactory;
    protected $fillable = ['title', 'status'];


    public function user(){return $this->belongsTo(User::class);}
    public function examQuestions(){return $this->hasMany(ExamQuestion::class);}
    public function questions()
    {
        return $this->hasManyThrough(Question::class, ExamQuestion::class, 'exam_id', 'id', 'id', 'question_id');
    }


//    public function getQuestions()
//    {
//        if(!is_array($this->data)) return json_decode($this->data, true);
//        else return $this->data;
//    }

}
