<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewedData extends Model
{
    use HasFactory;
    protected $table = 'recently_viewed_data';
    protected $fillable = ['user_id','course_id'];

    public function courseDetail()
    {
        return $this->hasOne('App\Models\Course','id','course_id');
    }
    
}
