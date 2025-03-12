<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransacoesSeeder extends Seeder
{
    public function run()
    {
        DB::table('transacoes')->insert([
            [
                'cpf_usuario' => '12345678901',
                'tipo' => 'Recebeu',
                'valor' => 100.50,
                'id_categoria' => 1,
                'data' => now(),
            ],
            [
                'cpf_usuario' => '12345678901',
                'tipo' => 'Pagou',
                'valor' => 50.00,
                'id_categoria' => 2,
                'data' => now(),
            ],
            [
                'cpf_usuario' => '45678912301',
                'tipo' => 'Pagou',
                'valor' => 20.00,
                'id_categoria' => 2,
                'data' => now(),
            ],
            [
                'cpf_usuario' => '10987654302',
                'tipo' => 'Pagou',
                'valor' => 249.90,
                'id_categoria' => 2,
                'data' => now(),
            ],
            [
                'cpf_usuario' => '12345678901',
                'tipo' => 'Pagou',
                'valor' => 700.00,
                'id_categoria' => 2,
                'data' => now(),
            ],
            [
                'cpf_usuario' => '10987654302',
                'tipo' => 'Pagou',
                'valor' => 50.00,
                'id_categoria' => 1,
                'data' => now(),
            ]
        ]);
    }
}

