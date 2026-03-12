<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bet;

class BetsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Bet::create([
            'user_id'       => 2,
            'match_id'      => 1,
            'odd_id'        => 1,
            'amount'        => 100.00,
            'potential_win' => 185.00,
            'status'        => 'pending',
            'created_at'    => now(),
        ]);

        Bet::create([
            'user_id'       => 3,
            'match_id'      => 1,
            'odd_id'        => 2,
            'amount'        => 50.00,
            'potential_win' => 105.00,
            'status'        => 'pending',
            'created_at'    => now(),
        ]);

        DB::table('bets')->insert([
            [
                'user_id'       => 4,
                'match_id'      => 2,
                'odd_id'        => 4,
                'amount'        => 200.00,
                'potential_win' => 380.00,
                'status'        => 'won',
                'created_at'    => now(),
            ],
            [
                'user_id'       => 2,
                'match_id'      => 2,
                'odd_id'        => 4,
                'amount'        => 75.00,
                'potential_win' => 142.50,
                'status'        => 'lost',
                'created_at'    => now(),
            ],
        ]);
    }
}