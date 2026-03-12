<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // VÍA MODELO
        User::create([
            'name'       => 'Admin Principal',
            'username'   => 'admin',
            'email'      => 'admin@apuestas.com',
            'password'   => Hash::make('password'),
            'balance'    => 5000.00,
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name'       => 'Pablo ',
            'username'   => 'pabloo',
            'email'      => 'pablo@apuestas.com',
            'password'   => Hash::make('password'),
            'balance'    => 1000.00,
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // VÍA DB
        DB::table('users')->insert([
            [
                'name'       => 'Meza',
                'username'   => 'mezai',
                'email'      => 'meza@apuestas.com',
                'password'   => Hash::make('password'),
                'balance'    => 750.00,
                'role'       => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'jaime p',
                'username'   => 'jimil',
                'email'      => 'pjaime@apuestas.com',
                'password'   => Hash::make('password'),
                'balance'    => 1200.00,
                'role'       => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}