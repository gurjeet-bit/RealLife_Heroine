<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
    use HasFactory;    
    protected $table = 'user_challenges';
    protected $fillable = ['admin_id','user_id','challenge_id','status'];

    public function challengeDetail(){
        return $this->hasOne('App\Models\Challenge','id','challenge_id');
    }

}

