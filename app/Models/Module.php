<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    use HasFactory;
    protected $table     = 'modules';
    protected $fillable  = ['course_id','name'];

    public function courseDetail()
    {
        return $this->hasOne('App\Models\Course','id','course_id');
    }

    public function lessonDetail()
    {
        return $this->hasMany('App\Models\Lesson','module_id','id');
    }

    public function questionaryDetail(){
        return $this->hasMany('App\Models\Questionary','module_id','id');
    }

    public function questionaryResponseDetail(){
        if($this->hasMany('App\Models\QuestionaryResponse','module_id','id')){
            return $this->hasMany('App\Models\QuestionaryResponse','module_id','id');
        }else{
            return array();
        }
    }

}
