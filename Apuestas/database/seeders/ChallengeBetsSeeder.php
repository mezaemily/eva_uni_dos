<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ChallengeBet;

class ChallengeBetsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        ChallengeBet::create([
            'challenge_id' => 1,
            'bet_id'       => 1,
            'created_at'   => now(),
        ]);

        ChallengeBet::create([
            'challenge_id' => 1,
            'bet_id'       => 2,
            'created_at'   => now(),
        ]);

        DB::table('challenge_bets')->insert([
            [
                'challenge_id' => 2,
                'bet_id'       => 3,
                'created_at'   => now(),
            ],
            [
                'challenge_id' => 2,
                'bet_id'       => 4,
                'created_at'   => now(),
            ],
        ]);
    }
}