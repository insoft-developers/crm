<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            "location_name" => "14A",
            "userid" => 1
        ]);
        Location::create([
            "location_name" => "14B",
            "userid" => 1
        ]);
        Location::create([
            "location_name" => "14C",
            "userid" => 1
        ]);
        Location::create([
            "location_name" => "14D",
            "userid" => 1
        ]);
        Location::create([
            "location_name" => "14E",
            "userid" => 1
        ]);
    }
}
