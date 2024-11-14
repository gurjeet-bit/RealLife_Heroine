<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondtion extends Model
{
    use HasFactory;
    protected $table = 'terms_and_conditions';
    protected $fillable = ['title','description'];
}
