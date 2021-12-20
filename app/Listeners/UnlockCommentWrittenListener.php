<?php

namespace App\Listeners;

use App\Traits\CommentAchievements;

class UnlockCommentWrittenListener
{
    use CommentAchievements;

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
    }
}
