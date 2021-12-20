<?php

namespace Tests\Unit;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementTest extends TestCase
{    
    use RefreshDatabase;

    /** @test */
    public function it_has_a_name()
    {
        $achievement = Achievement::factory()->create(['name' => 'Anonymous achievement']);
       
        $this->assertEquals('Anonymous achievement', $achievement->name);
    }
}
