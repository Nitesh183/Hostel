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
        \App\User::updateOrCreate([
            'name' => 'Shiwam Sah',
            'email' => 'shiwam@shiwam.com',
            'email_verified_at' => now(),
            'password' => bcrypt('shiwam@shiwam.com'),
            'admin' => 0,
            'approved_at' => now(),
        ]);
    }
}
