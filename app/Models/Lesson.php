<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table     = 'lessons';
    protected $fillable  = ['title','description','module_id','video'];

    public function moduleDetailForLesson(){
        return $this->belongsTo('App\Models\Module','module_id','id');
    }

    public function courseDetailForLesson(){
        return $this->belongsTo('App\Models\Course','course_id','id');
    }

}
