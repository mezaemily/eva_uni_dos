<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Challenge;

class ChallengesSeeder extends Seeder
{
    public function run(): void
    {
        //  MOD
        Challenge::create([
            'creator_id'  => 2,
            'opponent_id' => 3,
            'status'      => 'pending',
            'created_at'  => now(),
        ]);

        Challenge::create([
            'creator_id'  => 3,
            'opponent_id' => 4,
            'status'      => 'accepted',
            'created_at'  => now(),
        ]);

    
        DB::table('challenges')->insert([
            [
                'creator_id'  => 4,
                'opponent_id' => 2,
                'status'      => 'rejected',
                'created_at'  => now(),
            ],
            [
                'creator_id'  => 2,
                'opponent_id' => 4,
                'status'      => 'completed',
                'created_at'  => now(),
            ],
        ]);
    }
}