<?php

namespace Tests;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\UnlockAchievementBadgeListener;
use App\Listeners\UnlockCommentWrittenListener;
use App\Listeners\UnlockLessonWatchedListener;
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
        $this->seed([
            AchievementSeeder::class,
            BadgeSeeder::class,
        ]);
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
            $listener = new UnlockCommentWrittenListener();
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

        // Attach watched lessons to the user directly
        $tempCount = 0;

        foreach ($lessons as $lesson) {
            
            $user->lessons()->attach($lesson->id, ['watched' => true]);
            
            $tempCount++;

            // Events & Listening 
            $lessonWatched = new LessonWatched($lesson, $user);
            $listener = new UnlockLessonWatchedListener();
            $listener->handle($lessonWatched);

            if ($tempCount === $numberOfLessons) :
                break;
            endif;
        }
    }
}
