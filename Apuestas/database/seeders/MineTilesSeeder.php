<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MineTile;

class MineTilesSeeder extends Seeder
{
    public function run(): void
    {
        //  MOD
        MineTile::create([
            'game_id'  => 1,
            'position' => 3,
            'is_mine'  => false,
            'revealed' => true,
        ]);

        MineTile::create([
            'game_id'  => 1,
            'position' => 7,
            'is_mine'  => true,
            'revealed' => false,
        ]);

        DB::table('mine_tiles')->insert([
            [
                'game_id'  => 2,
                'position' => 12,
                'is_mine'  => true,
                'revealed' => true,
            ],
            [
                'game_id'  => 2,
                'position' => 20,
                'is_mine'  => false,
                'revealed' => false,
            ],
        ]);
    }
}