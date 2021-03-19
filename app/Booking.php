<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hostel_id',
        'owner_id',
        'room_id',
        'requestor_name',
        'requestor_address',
        'requestor_phone',
        'confirmed'
    ];
}
