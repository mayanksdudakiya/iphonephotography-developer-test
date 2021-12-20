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

    // Prepare an comment achievement response
    public function commentAchievementResponse()
    {
        $user = auth()->user();

        $response = [];

        $response['unlocked_achievements']['comment'] = '';

        // If user has no achievement then response with only next achievement 
        if (!empty($user->achievements)) :
            // Get latest/current comment achievement
            $currentCommentAchievement = $user->achievements->where('type', 'comment')->last();

            $response['unlocked_achievements']['comment'] = $currentCommentAchievement->name;

            // Get next comment achievement
            if (!empty($currentCommentAchievement)) :
                $nextCommentAchievement = $currentCommentAchievement->nextCommentAchievement;
            endif;
        else:
            // If no comment achievement then take the first comment achievement as next achievement
            $nextCommentAchievement = Achievement::commentType()->first();
        endif;

        $response['next_available_achievements']['comment'] = $nextCommentAchievement->name;

        return collect($response);
    }
}