<?php

namespace Tests\Unit;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementTest extends TestCase
{    
    use RefreshDatabase;

    /** @test */
    public function it_has_a_name_column()
    {
        $achievement = Achievement::factory()->create(['name' => 'Anonymous achievement']);
       
        $this->assertEquals('Anonymous achievement', $achievement->name);
    }

    /** @test */
    public function it_has_a_description_column()
    {
        $achievement = Achievement::factory()->create(['description' => 'An achievement awarded when comment count reached one']);
       
        $this->assertEquals('An achievement awarded when comment count reached one', $achievement->description);
    }

    /** @test */
    public function it_has_a_qualify_column()
    {
        $achievement = Achievement::factory()->create(['qualify' => 5]);
       
        $this->assertEquals(5, $achievement->qualify);
    }

    /** @test */
    public function it_has_a_type_column()
    {
        $achievement = Achievement::factory()->create(['type' => 'comment']);
       
        $this->assertEquals('comment', $achievement->type);
    }
}
