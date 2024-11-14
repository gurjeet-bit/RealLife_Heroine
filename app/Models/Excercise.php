<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excercise extends Model
{
    use HasFactory;
    protected $table     = 'excercises';
    protected $fillable  = ['module_id','course_id','lesson_id','excercise_name','excercise_title','excercise_description','attachment','exercise_form'];

    public function lessonData(){
        return $this->belongsTo('App\Models\Lesson','lesson_id','id');
    }
    
    

}

