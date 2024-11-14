<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMotivation extends Model
{
   use HasFactory;
   protected $table     = 'daily_motivations';
   protected $fillable  = ['quote','image','video'];

}
