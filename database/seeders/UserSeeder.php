<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\Str;

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
            'name'      => 'Rajan Barot',
            'email'     => 'rb@gmail.com',
            'password'  => Hash::make('12345678')
        ]);

        DB::table('users')->insert([
            'name'      => 'Manek Tech',
            'email'     => 'mt@gmail.com',
            'password'  => Hash::make('12345678')
        ]);
    }
}
