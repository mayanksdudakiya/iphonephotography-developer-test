<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentAchievementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function initial_response()
    {
        $user = User::factory()->create();
        
        $response = $this->get("/users/{$user->id}/achievements");

        $initialResponse = [
            'unlocked_achievements' => [
                'comment' => '',
                'lesson' => '',
                'badge' => 'Beginner'
            ],
            'next_available_achievements' => [
                'comment' => 'First Comment Written',
                'lesson' => 'First Lesson Watched',
                'badge' => 'Intermediate'
            ],
            'current_badge' => 'Beginner',
            'next_badge' => 'Intermediate',
            'remaining_to_unlock_next_badge' => 4,
        ];

        $response->assertJson($initialResponse);
    }

    /** @test */
    public function an_achievement_is_unlocked_when_user_written_first_comment()
    {
        $this->dataSeeder();

        $user = $this->authorizedUser();

        $this->generateComments(1, $user);

        // Check user's total comment inserted into the database
        $this->assertCount(1, $user->comments);
    }
}
