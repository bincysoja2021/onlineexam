<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

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
            'name'         => "Bincy",
            'email'        => 'bincysoja2017@gmail.com',
            'password'     => Hash::make('12345678')
        ]);

        DB::table('users')->insert([
            'name'         => "unni",
            'email'        => 'unni@gmail.com',
            'password'     => Hash::make('12345678')
        ]);
        DB::table('users')->insert([
            'name'         => "kiran",
            'email'        => 'kiran@gmail.com',
            'password'     => Hash::make('12345678')
        ]);

        DB::table('users')->insert([
            'name'         => "sonali",
            'email'        => 'sonali@gmail.com',
            'password'     => Hash::make('12345678')
        ]);

    }
}
