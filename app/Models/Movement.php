<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['visitor_id', 'location_name'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
