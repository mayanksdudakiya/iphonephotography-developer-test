<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            //Lesson Achievements
            ["qualify" => 1, "name" => "First Lesson Watched", "description" => "An achievement awarded to the user when user watched first lesson", "type" => "lesson"],
            ["qualify" => 5, "name" => "5 Lessons Watched", "description" => "An achievement awarded to the user when user watched five lessons", "type" => "lesson"],
            ["qualify" => 10, "name" => "10 Lessons Watched", "description" => "An achievement awarded to the user when user watched ten lessons", "type" => "lesson"],
            ["qualify" => 25, "name" => "25 Lessons Watched", "description" => "An achievement awarded to the user when user watched fifty five lessons", "type" => "lesson"],
            ["qualify" => 50, "name" => "50 Lessons Watched", "description" => "An achievement awarded to the user when user watched fifty lessons", "type" => "lesson"],

            //Comment Achievements
            ["qualify" => 1, "name" => "First Comment Written", "description" => "An achievement awarded to the user when user watched first comment", "type" => "comment"],
            ["qualify" => 3, "name" => "3 Comments Written", "description" => "An achievement awarded to the user when user watched three comments", "type" => "comment"],
            ["qualify" => 5, "name" => "5 Comments Written", "description" => "An achievement awarded to the user when user watched five comments", "type" => "comment"],
            ["qualify" => 10, "name" => "10 Comments Written", "description" => "An achievement awarded to the user when user watched ten comments", "type" => "comment"],
            ["qualify" => 20, "name" => "20 Comments Written", "description" => "An achievement awarded to the user when user watched twenty comments", "type" => "comment"],
        ];

        Achievement::insert($records);
    }
}
