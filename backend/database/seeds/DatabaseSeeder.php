<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Arthur Vilaca',
            'username' => 'arthur_vilaca',
            'email' => 'vilaca.arthur.f@gmail.com',
            'password' => bcrypt('123'),
            'status' => 'APROVADO'
        ]);

        DB::table('clients')->insert([
            'name' => 'Cliente 1',
            'status' => 'APROVADO'
        ]);

        DB::table('clients')->insert([
            'name' => 'Cliente 2',
            'status' => 'BLOQUEADO'
        ]);

        DB::table('providers')->insert([
            'name' => 'Fornecedor 1',
            'status' => 'APROVADO'
        ]);

        DB::table('providers')->insert([
            'name' => 'Fornecedor 2',
            'status' => 'BLOQUEADO'
        ]);

    }
}
