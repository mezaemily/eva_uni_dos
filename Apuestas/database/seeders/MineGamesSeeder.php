<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MineGame;

class MineGamesSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        MineGame::create([
            'user_id'    => 2,
            'bet_amount' => 50.00,
            'mines'      => 5,
            'multiplier' => 2.50,
            'winnings'   => 125.00,
            'status'     => 'won',
            'created_at' => now(),
        ]);

        MineGame::create([
            'user_id'    => 3,
            'bet_amount' => 100.00,
            'mines'      => 10,
            'multiplier' => 1.00,
            'winnings'   => 0.00,
            'status'     => 'lost',
            'created_at' => now(),
        ]);

        DB::table('mine_games')->insert([
            [
                'user_id'    => 4,
                'bet_amount' => 75.00,
                'mines'      => 3,
                'multiplier' => 1.80,
                'winnings'   => 135.00,
                'status'     => 'won',
                'created_at' => now(),
            ],
            [
                'user_id'    => 2,
                'bet_amount' => 200.00,
                'mines'      => 8,
                'multiplier' => 1.00,
                'winnings'   => 0.00,
                'status'     => 'playing',
                'created_at' => now(),
            ],
        ]);
    }
}