<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ["qualify" => 0, "name" => "Beginner", "description" => "A badge awarded to the user when user has no achievements"],
            ["qualify" => 4, "name" => "Intermediate", "description" => "A badge awarded to the user when user has received four achievements"],
            ["qualify" => 8, "name" => "Advanced", "description" => "A badge awarded to the user when user has received eight achievements"],
            ["qualify" => 10, "name" => "Master", "description" => "A badge awarded to the user when user has received ten achievements"],
        ];

        Badge::insert($records);
    }
}
