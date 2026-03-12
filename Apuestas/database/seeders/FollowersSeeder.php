<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Follower;

class FollowersSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Follower::create([
            'follower_id'  => 2,
            'following_id' => 3,
            'created_at'   => now(),
        ]);

        Follower::create([
            'follower_id'  => 3,
            'following_id' => 4,
            'created_at'   => now(),
        ]);

        DB::table('followers')->insert([
            [
                'follower_id'  => 4,
                'following_id' => 2,
                'created_at'   => now(),
            ],
            [
                'follower_id'  => 2,
                'following_id' => 4,
                'created_at'   => now(),
            ],
        ]);
    }
}