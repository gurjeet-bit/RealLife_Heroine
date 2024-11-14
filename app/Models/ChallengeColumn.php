<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeColumn extends Model
{
    use HasFactory;
    protected $table = 'challenge_columns';
    protected $fillable = ['challenge_id','question_id','field'];
}
