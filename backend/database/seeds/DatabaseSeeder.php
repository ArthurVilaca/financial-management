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
            'user_type' => 'U',
            'status' => 'APPROVED'
        ]);

    }
}
