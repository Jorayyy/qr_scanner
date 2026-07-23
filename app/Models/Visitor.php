<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    // This tells Laravel it is completely safe to save these form inputs!
    protected $fillable = [
        // 🆕 RESTRUCTURED: Split name components matching advisor guidelines
        'first_name',
        'middle_name',
        'last_name',
        
        'contact_number',
        'id_number',
        'purpose_of_visit',
        
        // 🆕 RESTRUCTURED: Both specific destination options (fully optional in database)
        'person_to_visit',
        'office_to_visit',
        
        'vehicle_type',
        'qr_code_token', // This matches our query locator field
        'status',
        'current_location',
        'checked_in_at',
        'checked_out_at',
        
        // NEW VEHICLE CODES ADDED BELOW
        'vehicle_brand',
        'vehicle_model',
        'vehicle_plate',
        'vehicle_color'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    /**
     * Get the logged movements for this visitor terminal session.
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    /**
     * 🆕 RELATIONSHIP: Fetch all historic trip summaries under this profile name.
     */
    public function history()
    {
        return $this->hasMany(Movement::class)->whereIn('action_type', ['CHECKED_IN', 'CHECKED_OUT'])->latest();
    }
}
