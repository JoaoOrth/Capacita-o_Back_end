<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@ecomp.co',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'email' => 'joaoadm@ecomp.co',
            'password' => bcrypt('bob'),
            'isAdmin' => true,
        ]);
    }
}
