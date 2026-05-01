<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class categories extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'description',
    ];

    /**
     * Relasi ke events.
     */
    public function events()
    {
        return $this->hasMany(event::class, 'category_id');
    }

    /**
     * Auto-generate slug dari name sebelum disimpan.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
