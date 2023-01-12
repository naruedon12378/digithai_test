<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('employees')->delete();
        \DB::table('employees')->insert([
                [
                    'first_name' => 'Somsri',
                    'last_name' => 'Samsung',
                    'company' => 1,
                    'email' => 'employee1@samsung.com',
                    'phone' => '0800000001',
                ],
                [
                    'first_name' => 'Somsak',
                    'last_name' => 'Apple',
                    'company' => 2,
                    'email' => 'employee2@apple.com',
                    'phone' => '0800000001',
                ]
            ]
        );
    }
}
