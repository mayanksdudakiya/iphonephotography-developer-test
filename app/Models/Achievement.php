<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    // Allow mass assignment for now
    protected $guarded = [];

    public $timestamps = true;

    // Pivot relationship with user & achievement
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')->withTimestamps();
    }

    // Get comment type achievement
    public function scopeCommentType($query)
    {
        $query->where('type', 'comment');
    }

    // Get lesson type achievement
    public function scopeLessonType($query)
    {
        $query->where('type', 'lesson');
    }
}
