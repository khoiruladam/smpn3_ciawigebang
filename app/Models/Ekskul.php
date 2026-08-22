<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, tapi baik untuk memastikan)
    protected $table = 'ekskuls';

    // Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'category',
        'cover_image',
        'gallery',
        'short_description',
        'description',
        'sort_order',
        'is_published',
    ];

    // Mengubah tipe data secara otomatis (Casting)
    protected $casts = [
        'gallery' => 'array', // Mengubah data text/JSON di database menjadi Array di PHP
        'is_published' => 'boolean',
    ];
}