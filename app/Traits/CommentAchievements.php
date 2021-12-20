<?php

namespace App\Traits;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

trait CommentAchievements {
    
    // Unlock comment achievement based on qualifier count
    public function unlockCommentAchievement()
    {
        // Get the current user
        $user = auth()->user();

        // Comment count
        $commentCount = $user->comments->count();
        
        // Get the comment achievements
        $allCommentAchievements = Achievement::commentType()->get();
       
        // Check comment count qualify for the achievement
        $commentAchievement = $allCommentAchievements->first( function($achievement) use ($commentCount) {
            return $achievement->qualify === $commentCount;
        }); 

        // Attach achievements to the user in user_achievements
        if (!empty($commentAchievement)) :
            $commentAchievement->awardTo($user);
            
            // Fire achievement unlock event
            AchievementUnlocked::dispatch($commentAchievement->name, $user);
        endif;
    }
}