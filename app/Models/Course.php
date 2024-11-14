<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table     = 'courses';
    protected $fillable  = ['title','description','video','thumbnail_image','author_id','category_id'];

    public function modules(){
        return $this->hasMany('App\Models\Module','course_id','id');
    }

    public function lessons(){
        return $this->hasMany('App\Models\Lesson','course_id','id');
    }
    
    public function excercises(){
        return $this->hasMany('App\Models\Excercise','course_id','id');
    }

    public function authorName(){
        return $this->belongsTo('App\Models\Author','author_id','id');
    }

}


