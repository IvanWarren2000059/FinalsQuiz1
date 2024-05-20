<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [   
                'id' => 1,
                'name' => 'Liam',
                'user_Type' => 'User',
                'email' => 'liam@gmail.com',
                'password' => bcrypt('liamrhysslim'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'name' => 'John',
                'user_Type' => 'User',
                'email' => 'john@gmail.com',
                'password' => bcrypt('johndoe'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
