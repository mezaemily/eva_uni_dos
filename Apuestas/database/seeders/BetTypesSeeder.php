<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BetType;

class BetTypesSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        BetType::create(['name' => 'Resultado final (1X2)']);
        BetType::create(['name' => 'Handicap asiático']);

        
        DB::table('bet_types')->insert([
            ['name' => 'Más/Menos goles'],
            ['name' => 'Ambos equipos marcan'],
        ]);
    }
}