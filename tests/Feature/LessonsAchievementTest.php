<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonsAchievementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_achievement_is_unlocked_when_user_watch_first_lesson()
    {
        $this->dataSeeder();

        $user = $this->authorizedUser();

        // User watched single lesson
        $this->generateLessons(1, $user);

        // Check user's total comment inserted into the database
        $this->assertCount(1, $user->watched);
    }
}
