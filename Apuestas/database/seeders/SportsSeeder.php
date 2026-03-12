<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sport;

class SportsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Sport::create(['name' => 'Fútbol',      'created_at' => now()]);
        Sport::create(['name' => 'Basquetbol',  'created_at' => now()]);

        // DB
        DB::table('sports')->insert([
            ['name' => 'Tenis',   'created_at' => now()],
            ['name' => 'Béisbol', 'created_at' => now()],
        ]);
    }
}