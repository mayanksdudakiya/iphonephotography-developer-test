<?php

namespace App\Listeners;

use App\Traits\BadgeAchievements;
use App\Traits\CommentAchievements;

class UnlockCommentWrittenListener
{
    use CommentAchievements, BadgeAchievements;

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

        // Unlock badge based on comment & lessons achievement
        $this->unlockBadge();
    }
}
