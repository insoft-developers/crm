<?php

namespace Database\Seeders;

use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPosition::create([
            "id" => 1,
            "position_name" => "Owner",
        ]);
        UserPosition::create([
            "id" => 2,
            "position_name" => "staff",
        ]);
        UserPosition::create([
            "id" => 3,
            "position_name" => "Supervisor",
        ]);
        UserPosition::create([
            "id" => 4,
            "position_name" => "Manager",
        ]);
        UserPosition::create([
            "id" => 5,
            "position_name" => "General Manager",
        ]);
        UserPosition::create([
            "id" => 6,
            "position_name" => "Unit Head",
        ]);
        UserPosition::create([
            "id" => 7,
            "position_name" => "Director",
        ]);
        
    }
}
