<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            SportsSeeder::class,
            TeamsSeeder::class,
            MatchesSeeder::class,
            BetTypesSeeder::class,
            OddsSeeder::class,
            BetsSeeder::class,
            ChallengesSeeder::class,
            ChallengeBetsSeeder::class,
            CommentsSeeder::class,
            FollowersSeeder::class,
            TransactionsSeeder::class,
            MineGamesSeeder::class,
            MineTilesSeeder::class,
        ]);
    }
}