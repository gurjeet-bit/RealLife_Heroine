<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $table = 'challenges';
    protected $fillable = ['name'];

    public function challengeQuestionDetails(){
        return $this->hasMany('App\Models\ChallengeQuestion','challenge_id','id');
    }


    public function challengeResponse(){
        if($this->hasMany('App\Models\ChallengeResponse','challenge_id','id')){
            return $this->hasMany('App\Models\ChallengeResponse','challenge_id','id');
        }else{
            return array();
        }      
    }
    

}
