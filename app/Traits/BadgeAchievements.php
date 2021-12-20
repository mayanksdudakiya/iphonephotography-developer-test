<?php

namespace App\Traits;

use App\Events\BadgeUnlocked;
use App\Models\Badge;

trait BadgeAchievements {

    // Unlock badge based on comment & lesson achievements count with qualify
    public function unlockBadge()
    {
        // Get the current user
        $user = auth()->user();

        // Get total achievement count from pivot table
        $achievementsCount = $user->achievements->count();

        // Get the all lessons achievements
        $allBadges = Badge::get();

        // Default assign first badge on count of 0 or 1
        if ($achievementsCount <= 1) :
            $initialBadge = $allBadges->first();
            
            // Attach badge to user
            $initialBadge->awardTo($user);

            // Fire badge unlock event
            BadgeUnlocked::dispatch($initialBadge->name, $user);
        else:
            // Now check number of achievement with qualify badge column
            $badgeAwarded = $allBadges->first( function($badge) use ($achievementsCount) {
                return $badge->qualify === $achievementsCount;
            }); 

            // Attach badge to the user in user_badges
            if (!empty($badgeAwarded)) :
                $badgeAwarded->awardTo($user);
                
                // Fire badge unlock event
                BadgeUnlocked::dispatch($badgeAwarded->name, $user);
            endif;
        endif;
    }

    // Prepare an lesson achievement response
    public function badgeResponse()
    {
        $user = auth()->user();

        $response = [];
        
        // If user has no achievement then response with only next achievement 
        if ($user->badges->count() > 0) :
            

            // Get latest/current badge
            $currentBadge = $user->badges->last();

            // Get next badge  
            if (!empty($currentBadge)) :
                $nextBadge = $currentBadge->nextBadge;
            endif;
        else:
            // If no badge awarded then take the first badge as initial
            $currentBadge = Badge::first();
            $nextBadge = $currentBadge->nextBadge;
        endif;

        $response['current_badge'] = $currentBadge->name;
        $response['next_badge'] = $nextBadge->name;
        $response['remaining_to_unlock_next_badge'] = $nextBadge->qualify;

        return collect($response);
    }
}