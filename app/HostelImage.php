<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostelImage extends Model
{
    protected $table = 'hostel_image';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hostel_id',
        'filename',
    ];
}
