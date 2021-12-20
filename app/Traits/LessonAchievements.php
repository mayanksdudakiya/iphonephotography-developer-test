<?php

namespace App\Traits;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

trait LessonAchievements {
    
    // Unlock comment achievement based on qualifier count
    public function unlockLessonAchievement()
    {
        // Get the current user
        $user = auth()->user();

        // Watched lessons count
        $watchedLessonsCount = $user->watched->count();
        
        // Get the all lessons achievements
        $allLessonAchievements = Achievement::lessonType()->get();
        
        // Check watched lesson count qualify for the achievement
        $lessonAchievement = $allLessonAchievements->first( function($achievement) use ($watchedLessonsCount) {
            return $achievement->qualify === $watchedLessonsCount;
        }); 

        // Attach achievements to the user in user_achievements
        if (!empty($lessonAchievement)) :
            $lessonAchievement->awardTo($user);
            
            // Fire achievement unlock event
            AchievementUnlocked::dispatch($lessonAchievement->name, $user);
        endif;
    }

    // Prepare an lesson achievement response
    public function lessonAchievementResponse()
    {
        $user = auth()->user();

        $response = [];

        $response['unlocked_achievements']['lesson'] = '';
        
        $isLessonAchievementExists = $user->achievements->where('type', 'lesson')->count();

        // If user has no achievement then response with only next achievement 
        if ($isLessonAchievementExists > 0) :

            // Get latest/current comment achievement
            $currentLessonAchievement = $user->achievements->where('type', 'lesson')->last();

            $response['unlocked_achievements']['lesson'] = $currentLessonAchievement->name;

            // Get next comment achievement
            if (!empty($currentLessonAchievement)) :
                $nextLessonAchievement = $currentLessonAchievement->nextLessonAchievement;
            endif;
        else:
            // If no lesson achievement then take the first lesson achievement as next achievement
            $nextLessonAchievement = Achievement::lessonType()->first();
        endif;

        $response['next_available_achievements']['lesson'] = $nextLessonAchievement->name;

        return collect($response);
    }
}