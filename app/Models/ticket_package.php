<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ticket_package extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'price',
        'quota',
        'event_id',
    ];

    public function event()
    {
        return $this->belongsTo(event::class);
    }

    public function bookings()
    {
        return $this->hasMany(bookings::class);
    }
}
