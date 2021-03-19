<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HostelImage;
use DB;
use Auth;

class Hostel extends Model
{
    protected $table = 'hostel';
    protected $primaryKey = 'hostel_id';
    protected $fillable = [
        'owner_id',
        'hostel_name',
        'description',
        'address',
        'phone_number',
        'contact_person',
        'accomodation_for'
    ];

    public function getImages()
    {
        /* Defining 1 to many relation. Hostel table has many images i.e. 
        Hostel image table can have many references of single hostel.
        Parameters are passed in order, Foreign key and local key/PK */
        return $this->hasMany('App\HostelImage', 'hostel_id', 'hostel_id');
    }

    /* Many-To-Many relation between Hostel and HostelRoom
    This function gets all rooms belonging to a given hostel.
    */
    public function getRooms()
    {
        /* hostel_room is the
         pivot/joining/linking/intermediate table
         withPivot gets extra columns from the pivot table */
        return $this->belongsToMany('App\Room', 'hostel_room', 'hostel_id', 'room_id')
            ->withPivot('room_price', 'available_quantity')
            ->withTimestamps();
    }

    public function getOwner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }
}
