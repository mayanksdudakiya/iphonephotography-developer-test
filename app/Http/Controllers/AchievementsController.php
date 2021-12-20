<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\BadgeAchievements;
use App\Traits\CommentAchievements;
use App\Traits\LessonAchievements;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    use CommentAchievements, LessonAchievements, BadgeAchievements;

    public function index(User $user)
    {
        // Get the comment response from the trait
        $commentResponse = $this->commentAchievementResponse();
        
        // Get the lesson response from the trait
        $lessonResponse = $this->lessonAchievementResponse();
        
        // Merge comment & lessons's inner collection array
        $commentLessonResponse = $commentResponse->mergeRecursive($lessonResponse);

        $badgeResponse = $this->badgeResponse();
        
        $response = collect($commentLessonResponse)->merge($badgeResponse);
        
        return response()->json($response);
    }
}
