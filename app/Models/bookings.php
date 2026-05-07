<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{
    protected $fillable = [
        'order_id',
        'ticket_code',
        'ticket_package_id',
        'user_id',
        'price',
        'status',
        'check_in_at',
        'quantity',
        'snap_token',
    ];

    public function ticketPackage()
    {
        return $this->belongsTo(ticket_package::class, 'ticket_package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
