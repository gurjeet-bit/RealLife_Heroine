<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedDocument extends Model
{
    use HasFactory;
    protected $table = 'saved_documents';
    protected $fillable = ['excercise_id','lesson_id','user_id','course_id'];

    public function excerciseData(){
        return $this->belongsTo('App\Models\Excercise','excercise_id','id');
    }

}
