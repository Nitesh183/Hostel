<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    protected $primaryKey = 'room_id';
    protected $fillable = [
        'type',
        'description'
    ];

    /* Many-To-Many relation between Hostel and HostelRoom
    This function gets all hostels belonging to a given room.
    */
    public function getHostels()
    {
        /* hostel_room is the
         pivot/joining/linking/intermediate table
         withPivot gets extra columns from the pivot table */
        return $this->belongsToMany('App\Hostel', 'hostel_room', 'room_id', 'hostel_id')
            ->withPivot('room_price', 'available_quantity')
            ->withTimestamps();
    }   

}
