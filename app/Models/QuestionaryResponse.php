<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaryResponse extends Model
{
    use HasFactory;
    protected $table     = 'questionary_response';
    protected $fillable  = ['user_id','module_id','questionary_id','answer'];

    public function questionDetail(){
        return $this->hasMany('App\Models\QuestionaryColumn','questionary_id','id');
    }
}
