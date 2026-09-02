<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $table = 'seo_metas';

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
    ];

    /**
     * Relasi polymorphic kembali ke model induk (Post, Ekskul, Facility, dll).
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
