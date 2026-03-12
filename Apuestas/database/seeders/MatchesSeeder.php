<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GameMatch;

class MatchesSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        GameMatch::create([
            'sport_id'     => 1,
            'team_home_id' => 1,
            'team_away_id' => 2,
            'match_date'   => now()->addDays(3),
            'status'       => 'scheduled',
            'created_at'   => now(),
        ]);

        GameMatch::create([
            'sport_id'     => 2,
            'team_home_id' => 3,
            'team_away_id' => 4,
            'match_date'   => now()->addDays(5),
            'status'       => 'scheduled',
            'created_at'   => now(),
        ]);


        DB::table('matches')->insert([
            [
                'sport_id'     => 1,
                'team_home_id' => 2,
                'team_away_id' => 1,
                'match_date'   => now()->addDays(7),
                'home_score'   => null,
                'away_score'   => null,
                'status'       => 'scheduled',
                'created_at'   => now(),
            ],
            [
                'sport_id'     => 2,
                'team_home_id' => 4,
                'team_away_id' => 3,
                'match_date'   => now()->subDays(1),
                'home_score'   => 102,
                'away_score'   => 98,
                'status'       => 'finished',
                'created_at'   => now(),
            ],
        ]);
    }
}