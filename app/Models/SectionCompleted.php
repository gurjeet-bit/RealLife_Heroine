<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCompleted extends Model
{
    use HasFactory;
    protected $table = 'section_completed';
    protected $fillable = ['user_id','challenge_id','video_id','blog_id','podcast_id','course_id'];
}

