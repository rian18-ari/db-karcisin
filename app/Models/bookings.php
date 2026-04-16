<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{
    protected $fillable = [
        'ticket_code',
        'ticket_package_id',
        'user_id',
        'price',
        'proof_of_payment',
        'status',
        'check_in_at',
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
