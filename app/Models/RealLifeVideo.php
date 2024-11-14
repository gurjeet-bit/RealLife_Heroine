<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealLifeVideo extends Model
{
    use HasFactory;
    protected $table = 'real_life_videos';
    protected $fillable = ['title','description','video','thumbnail_image'];
}
