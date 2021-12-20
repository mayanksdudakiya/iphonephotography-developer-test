<?php

namespace Tests\Unit;

use App\Models\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_a_name_column()
    {
        $badge = Badge::factory()->create(['name' => 'Anonymous badge']);
       
        $this->assertEquals('Anonymous badge', $badge->name);
    }

    /** @test */
    public function it_has_a_description_column()
    {
        $badge = Badge::factory()->create(['description' => 'An badge awarded when achievement count reached one']);
       
        $this->assertEquals('An badge awarded when achievement count reached one', $badge->description);
    }

    /** @test */
    public function it_has_a_qualify_column()
    {
        $badge = Badge::factory()->create(['qualify' => 5]);
       
        $this->assertEquals(5, $badge->qualify);
    }
}
