<?php

namespace App\Listeners;

use App\Traits\BadgeAchievements;
use App\Traits\CommentAchievements;
use App\Traits\LessonAchievements;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockAchievementBadgeListener
{
    use CommentAchievements, LessonAchievements, BadgeAchievements;
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Unlock comment achievement business logic from trait
        $this->unlockCommentAchievement();

        // Unlock lesson achievement business logic from trait
        $this->unlockLessonAchievement();

        // Unlock badge based on comment & lessons achievement
        $this->unlockBadge();
    }
}
