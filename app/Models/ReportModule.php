<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModule extends Model
{
    use HasFactory;
    protected $table = 'report_modules';
    protected $fillable = ['course_id','module_id','lesson_id','user_id'];

    public function courseDetail(){
        return $this->hasOne('App\Models\Course','id','course_id');
    }

}


