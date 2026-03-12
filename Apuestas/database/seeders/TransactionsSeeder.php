<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class TransactionsSeeder extends Seeder
{
    public function run(): void
    {
        //  MOD
        Transaction::create([
            'user_id'     => 2,
            'type'        => 'deposit',
            'amount'      => 1000.00,
            'description' => 'Depósito inicial de bienvenida',
            'created_at'  => now(),
        ]);

        Transaction::create([
            'user_id'     => 3,
            'type'        => 'deposit',
            'amount'      => 750.00,
            'description' => 'Recarga de saldo',
            'created_at'  => now(),
        ]);

        DB::table('transactions')->insert([
            [
                'user_id'     => 4,
                'type'        => 'withdrawal',
                'amount'      => 300.00,
                'description' => 'Retiro a cuenta bancaria',
                'created_at'  => now(),
            ],
            [
                'user_id'     => 2,
                'type'        => 'bet_win',
                'amount'      => 380.00,
                'description' => 'Ganancia por apuesta #3',
                'created_at'  => now(),
            ],
        ]);
    }
}