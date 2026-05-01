<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'latitude',
        'longitude',
        'location',
        'start_date',
        'end_date',
        'status',
        'image',
        'category_id',
        'user_id',
    ];

    public function tickets()
    {
        return $this->hasMany(ticket_package::class);
    }

    public function category()
    {
        return $this->belongsTo(categories::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
