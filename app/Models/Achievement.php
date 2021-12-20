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

    // Attach users with achievement in pivot table
    public function awardTo(User $user)
    {
        $this->users()->attach($user);
    }

    // Get next comment achievement
    public function getNextCommentAchievementAttribute()
    {
        return static::where('id', '>', $this->id)
                    ->where('type', 'comment')
                    ->orderBy('id','asc')
                    ->first();
    }

    // Get next lesson achievement
    public function getNextLessonAchievementAttribute()
    {
        return static::where('id', '>', $this->id)
                    ->where('type', 'lesson')
                    ->orderBy('id','asc')
                    ->first();
    }
}
