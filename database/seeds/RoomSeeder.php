<?php

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            ['room_id' => 1, 'type' => 'Single Private', 'description' => 'desc 1'],
            ['room_id' => 2, 'type' => 'Shared', 'description' => 'desc 2'],
            ['room_id' => 3, 'type' => 'Flat', 'description' => 'desc 3'],
            ['room_id' => 4, 'type' => 'Furnished Flat', 'description' => 'desc 4'],
        ];

        foreach ($rows as $row) {
            \App\Room::updateOrCreate(['room_id' => $row['room_id']], $row);
        }
    }
}
