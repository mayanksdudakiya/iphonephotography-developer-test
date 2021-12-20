<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentAchievementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function initial_response()
    {
        $this->dataSeeder();
        
        $user = User::factory()->create();

        $this->actingAs($user)->get('/login');
        
        $response = $this->get("/users/{$user->id}/achievements");

        $initialResponse = [
            'unlocked_achievements' => [
                'comment' => '',
                'lesson' => '',
            ],
            'next_available_achievements' => [
                'comment' => 'First Comment Written',
                'lesson' => 'First Lesson Watched',
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
        Event::fake();

        $this->dataSeeder();

        $user = $this->authorizedUser();

        $this->generateComments(1, $user);

        // Check user's total comment inserted into the database
        $this->assertCount(1, $user->comments);

        $response = $this->get("/users/{$user->id}/achievements");

        $initialResponse = [
            'unlocked_achievements' => [
                'comment' => 'First Comment Written',
                'lesson' => '',
            ],
            'next_available_achievements' => [
                'comment' => '3 Comments Written',
                'lesson' => 'First Lesson Watched',
            ],
            'current_badge' => 'Beginner',
            'next_badge' => 'Intermediate',
            'remaining_to_unlock_next_badge' => 4,
        ];

        $response->assertJson($initialResponse);
    }

    /** @test */
    public function an_achievement_is_unlocked_when_user_written_three_comments()
    {
        Event::fake();
        
        $this->dataSeeder();

        $user = $this->authorizedUser();

        $this->generateComments(3, $user);

        $response = $this->get("/users/{$user->id}/achievements");

        $initialResponse = [
            'unlocked_achievements' => [
                'comment' => '3 Comments Written',
                'lesson' => '',
            ],
            'next_available_achievements' => [
                'comment' => '5 Comments Written',
                'lesson' => 'First Lesson Watched',
            ],
            'current_badge' => 'Beginner',
            'next_badge' => 'Intermediate',
            'remaining_to_unlock_next_badge' => 4,
        ];

        $response->assertJson($initialResponse);
    }
}
