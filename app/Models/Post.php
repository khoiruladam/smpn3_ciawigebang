<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasSeo;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'image',
        'excerpt',
        'body',
        'is_published',
    ];

    /**
     * Auto-generate slug hanya saat record BARU dibuat.
     * Saat update, slug tidak berubah agar URL tetap stabil (SEO friendly).
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . time();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}