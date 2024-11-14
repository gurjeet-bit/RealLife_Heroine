<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submittedexcercises extends Model
{
    use HasFactory;
    protected $table     = 'submitted_excercises';
    protected $fillable  = ['user_id','excercise_id','submitted_data'];

    public function lessonData(){
        return $this->belongsTo('App\Models\Excercise','excercise_id','id');
    }
    
    

}

