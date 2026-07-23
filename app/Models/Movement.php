<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    // 🔑 THIS ARRAY SEALS THE HOLE. It tells Laravel it is allowed to write data to these columns!
    protected $fillable = [
        'visitor_id',
        'action_type',    // 🔴 ADD THIS EXACT LINE IF IT IS MISSING OR TYPO'D!
        'location_name',
        'remarks'
    ];
}