<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'icon',
        'name',
        'slug',
        'tag',
        'short_description',
        'description',
        'cover_image',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function images()
    {
        return $this->hasMany(FacilityImage::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug'; // supaya URL pakai /fasilitas/{slug}, bukan /fasilitas/{id}
    }
}