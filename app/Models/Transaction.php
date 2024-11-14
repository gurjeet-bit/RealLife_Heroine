<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'reward_id',
        'points',
        'type',        
    ];

    protected $appends = [
        'module'
    ];

    public function getModuleAttribute()
    {
        return Module::where('id', $this->attributes['module_id'])
            ->pluck('name')
            ->first();
    }
}
