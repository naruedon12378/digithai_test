<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $password = Hash::make('password');
        \DB::table('users')->delete();
        \DB::table('users')->insert([
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => $password,
                ]
            ]
        );
    }
}
