<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->delete();
        \DB::table('companies')->insert([
                [
                    'name' => 'Samsung',
                    'address' => 'xxx/xxx xxxxxx xxxxxx xxxxxx 12345',
                    'email' => 'info@samsung.com',
                    'logo' => 'samsung_logo.jpg',
                    'website' => 'www.samsung.com',
                ],
                [
                    'name' => 'Apple',
                    'address' => 'yyy/yyy yyyyyy yyyyyy yyyyyy 12345',
                    'email' => 'info@apple.com',
                    'logo' => 'apple_logo.jpg',
                    'website' => 'www.apple.com',
                ]
            ]
        );
    }
}
