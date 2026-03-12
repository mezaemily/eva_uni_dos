<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Team;

class TeamsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Team::create(['sport_id' => 1, 'name' => 'Real Madrid',   'strength' => 90, 'created_at' => now()]);
        Team::create(['sport_id' => 1, 'name' => 'FC Barcelona',  'strength' => 88, 'created_at' => now()]);

        
        DB::table('teams')->insert([
            ['sport_id' => 2, 'name' => 'LA Lakers',     'strength' => 85, 'created_at' => now()],
            ['sport_id' => 2, 'name' => 'Chicago Bulls', 'strength' => 80, 'created_at' => now()],
        ]);
    }
}