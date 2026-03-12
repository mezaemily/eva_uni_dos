<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Odd;

class OddsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Odd::create([
            'match_id'    => 1,
            'bet_type_id' => 1,
            'option_name' => 'Real Madrid gana',
            'odd_value'   => 1.85,
            'created_at'  => now(),
        ]);

        Odd::create([
            'match_id'    => 1,
            'bet_type_id' => 1,
            'option_name' => 'FC Barcelona gana',
            'odd_value'   => 2.10,
            'created_at'  => now(),
        ]);

        
        DB::table('odds')->insert([
            [
                'match_id'    => 1,
                'bet_type_id' => 1,
                'option_name' => 'Empate',
                'odd_value'   => 3.40,
                'created_at'  => now(),
            ],
            [
                'match_id'    => 2,
                'bet_type_id' => 3,
                'option_name' => 'Más de 200.5 puntos',
                'odd_value'   => 1.90,
                'created_at'  => now(),
            ],
        ]);
    }
}