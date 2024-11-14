<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaryColumn extends Model
{
    use HasFactory;
    protected $table     = 'questionary_columns';
    protected $fillable  = ['questionary_id','field'];
}
