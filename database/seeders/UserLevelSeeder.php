<?php

namespace Database\Seeders;

use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::create([
            "id" => 1,
            "level_name" => "Administrator"
        ]);

        UserLevel::create([
            "id" => 2,
            "level_name" => "Admin"
        ]);

        UserLevel::create([
            "id" => 3,
            "level_name"=>"Operator"
        ]);
    }
}
