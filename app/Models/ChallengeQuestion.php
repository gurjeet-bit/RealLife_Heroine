<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeQuestion extends Model
{

    use HasFactory;
    protected $table = 'challenge_questions';
    protected $fillable = ['challenge_id','question','question_type','status'];

    public function challengeColumns(){
        return $this->hasMany('App\Models\ChallengeColumn','question_id','id');
    }

    public function challengeResponse(){
        if($this->hasOne('App\Models\ChallengeResponse','question_id','id')){
            return $this->hasOne('App\Models\ChallengeResponse','question_id','id');
        }else{
            return array();
        }        
    }

}
