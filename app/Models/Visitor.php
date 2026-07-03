<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    // This tells Laravel it is completely safe to save these form inputs!
    protected $fillable = [
        'full_name',
        'contact_number',
        'id_number',
        'purpose_of_visit',
        'person_to_visit',
        'qr_code_token',
        'status',
        'current_location',
        'checked_in_at',
        'checked_out_at'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

        public function movements()
    {
        return $this->hasMany(Movement::class);
    }

}
