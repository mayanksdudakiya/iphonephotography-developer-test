<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AchievementTest extends TestCase
{    
    /** @test */
    public function it_has_a_name()
    {
        $achievement = Achievement::factory()->create(['name' => 'Anonymous achievement']);
       
        $this->assertEquals('Anonymous achievement', $achievement->name);
    }
}
