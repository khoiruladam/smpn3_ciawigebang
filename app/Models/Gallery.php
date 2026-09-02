<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, HasSeo;

    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'slug',
        'caption',
        'category',
        'image',
        'is_featured',
        'sort_order',
        'is_published',
    ];

    /**
     * Auto-generate slug dari title saat record baru dibuat.
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}