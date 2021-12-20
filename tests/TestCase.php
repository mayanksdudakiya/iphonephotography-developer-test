<?php

namespace Tests;

use App\Events\CommentWritten;
use App\Listeners\UnlockAchievementBadgeListener;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Wakeup data seeder for testing
     */
    protected function dataSeeder()
    {
        $this->seed();

        $this->seed(AchievementSeeder::class);

        $this->seed(BadgeSeeder::class);
    }

    /**
     * Create a user
     * Check user authentication
     */
    protected function authorizedUser()
    {
        // Create a user
        $user = User::factory()->create();

        // Check user authentication
        $this->actingAs($user)->get('/login');

        return $user;
    }

    /**
     * Generate number of comments for given user
     */
    protected function generateComments($numberOfComments, $user)
    {
        for ($i = 0; $i < $numberOfComments; $i++) {
            
            $attributes = [
                'body' => $this->faker->sentence,
                'user_id' => $user->id
            ];

            // Create comment
            $comment = Comment::factory()->create($attributes);

            // Events & Listening 
            $commentCreated = new CommentWritten($comment);
            $listener = new UnlockAchievementBadgeListener();
            $listener->handle($commentCreated);
        }
    }

    /**
     * Generate number of lessons watched for given user
     */
    protected function generateLessons($numberOfLessons, $user)
    {   
        // Get all the lessons
        $lessons = Lesson::get();

        // Attach all the lessons to the user
        foreach ($lessons as $lesson) {
            $user->lessons()->attach($lesson->id, ['watched' => false]);
        }
        
        // Number of lessons watched by the user 
        for ($i = 0; $i < $numberOfLessons; $i++) {
            
        }
    }
}
