<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'Muhammad Abdurrahman',
            'email'  => 'rachman.sd@gmail.com',
            'phone'  => '08211111111',
            'level'  => 1,
            'password'  => \Illuminate\Support\Facades\Hash::make('1234554321')
        ]);
    }
}
