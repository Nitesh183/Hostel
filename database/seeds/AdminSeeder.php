<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::updateOrCreate([
            'name' => 'Nitesh Sah',
            'email' => 'niteshsah183@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('hostel'),
            'admin' => 1,
            'approved_at' => now(),
        ]);
    }
}
