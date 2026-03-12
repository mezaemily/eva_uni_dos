<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        // MOD
        Comment::create([
            'user_id'    => 2,
            'match_id'   => 1,
            'content'    => 'Este partido va a estar increíble, apuesto por el Real Madrid.',
            'created_at' => now(),
        ]);

        Comment::create([
            'user_id'    => 3,
            'match_id'   => 1,
            'content'    => 'El Barça tiene mejor forma últimamente, creo que ganan ellos.',
            'created_at' => now(),
        ]);

        DB::table('comments')->insert([
            [
                'user_id'    => 4,
                'match_id'   => 2,
                'content'    => 'Los Lakers están en racha, buena cuota para apostar.',
                'created_at' => now(),
            ],
            [
                'user_id'    => 2,
                'match_id'   => 2,
                'content'    => 'El partido de ayer estuvo emocionante hasta el final.',
                'created_at' => now(),
            ],
        ]);
    }
}