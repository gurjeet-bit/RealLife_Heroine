<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionary extends Model
{

    use HasFactory;
    protected $table     = 'questionaires';
    protected $fillable  = ['module_id','question','question_type','link_name','link_url'];    

    public function questionaryColumn(){
        return $this->hasMany('App\Models\QuestionaryColumn','questionary_id','id');
    }

    public function questionaryResponseDetail(){
        if($this->hasOne('App\Models\QuestionaryResponse','questionary_id','id')){
            return $this->hasOne('App\Models\QuestionaryResponse','questionary_id','id');
        }else{
            return array();
        }        
    }

}






