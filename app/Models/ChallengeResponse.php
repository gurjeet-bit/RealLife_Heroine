<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeResponse extends Model
{
    use HasFactory;
    protected $table = 'challenge_responses';
    protected $fillable = ['challenge_id','user_id','question_id','response_id','answer'];

}
