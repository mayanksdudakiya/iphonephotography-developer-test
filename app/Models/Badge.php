<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    // Allow mass assignment for now
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')->withTimestamps();
    }

    // Get next lesson achievement
    public function getNextBadgeAttribute()
    {
        return static::where('id', '>', $this->id)
                    ->orderBy('id','asc')
                    ->first();
    }
}
