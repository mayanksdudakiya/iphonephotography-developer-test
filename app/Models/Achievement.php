<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    // Allow mass assignment for now
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')->withTimestamps();
    }
}
