<?php

namespace App\Listeners;

use App\Traits\BadgeAchievements;
use App\Traits\LessonAchievements;

class UnlockLessonWatchedListener
{
    use LessonAchievements, BadgeAchievements;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Unlock lesson achievement business logic from trait
        $this->unlockLessonAchievement();

        // Unlock badge based on comment & lessons achievement
        $this->unlockBadge();
    }
}
