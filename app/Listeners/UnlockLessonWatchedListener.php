<?php

namespace App\Listeners;

use App\Traits\LessonAchievements;

class UnlockLessonWatchedListener
{
    use LessonAchievements;

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
    }
}
