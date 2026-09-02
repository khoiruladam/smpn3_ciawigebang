<?php

namespace App\Traits;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Trait HasSeo
 *
 * Attach ke model manapun yang butuh fitur SEO management.
 * Menyediakan relasi morphOne ke SeoMeta, fallback otomatis dari field
 * yang sudah ada di model, serta method saveSeo() yang idempotent.
 *
 * Cara pakai: `use HasSeo;` di dalam class Model.
 */
trait HasSeo
{
    /**
     * Boot trait: hapus data SEO saat model dihapus.
     */
    public static function bootHasSeo(): void
    {
        static::deleting(function ($model) {
            if ($model->seo) {
                // Hapus file og_image dari storage jika ada
                if ($model->seo->og_image && Storage::disk('public')->exists($model->seo->og_image)) {
                    Storage::disk('public')->delete($model->seo->og_image);
                }
                $model->seo->delete();
            }
        });
    }

    /**
     * Relasi polymorphic one-to-one ke SeoMeta.
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * Mendapatkan meta title dengan fallback ke field judul model.
     */
    public function getSeoTitle(): string
    {
        if ($this->seo && $this->seo->meta_title) {
            return $this->seo->meta_title;
        }

        // Fallback: coba field 'title', lalu 'name'
        return $this->title ?? $this->name ?? config('app.name', 'SMPN 3 Ciawigebang');
    }

    /**
     * Mendapatkan meta description dengan fallback ke field deskripsi model.
     */
    public function getSeoDescription(): string
    {
        if ($this->seo && $this->seo->meta_description) {
            return $this->seo->meta_description;
        }

        // Fallback: coba excerpt, short_description, body, description, caption
        $content = $this->excerpt
            ?? $this->short_description
            ?? $this->body
            ?? $this->description
            ?? $this->caption
            ?? '';

        $fallback = Str::limit(strip_tags($content), 160, '');

        return $fallback ?: 'SMP Negeri 3 Ciawigebang — Website resmi sekolah.';
    }

    /**
     * Mendapatkan meta keywords.
     */
    public function getSeoKeywords(): ?string
    {
        return $this->seo?->meta_keywords;
    }

    /**
     * Mendapatkan URL gambar OG dengan fallback ke cover/image model.
     */
    public function getOgImageUrl(): ?string
    {
        if ($this->seo && $this->seo->og_image) {
            return Storage::url($this->seo->og_image);
        }

        // Fallback: coba cover_image, lalu image
        $fallbackImage = $this->cover_image ?? $this->image ?? null;

        if ($fallbackImage) {
            return Str::startsWith($fallbackImage, 'http')
                ? $fallbackImage
                : Storage::url($fallbackImage);
        }

        return null;
    }

    /**
     * Mendapatkan canonical URL dengan fallback ke URL saat ini.
     */
    public function getCanonicalUrl(): string
    {
        if ($this->seo && $this->seo->canonical_url) {
            return $this->seo->canonical_url;
        }

        return request()->url();
    }

    /**
     * Simpan atau update data SEO dari request form.
     * Menggunakan updateOrCreate agar idempotent.
     */
    public function saveSeo(Request $request): void
    {
        // Cek apakah ada field SEO yang diisi
        $hasSeoData = $request->filled('meta_title')
            || $request->filled('meta_description')
            || $request->filled('meta_keywords')
            || $request->filled('canonical_url')
            || $request->hasFile('og_image');

        if (!$hasSeoData && !$this->seo) {
            return; // Tidak ada data SEO dan belum pernah disimpan, skip
        }

        $data = [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'canonical_url' => $request->input('canonical_url'),
        ];

        // Upload og_image jika ada file baru
        if ($request->hasFile('og_image')) {
            // Hapus file lama jika ada
            if ($this->seo && $this->seo->og_image && Storage::disk('public')->exists($this->seo->og_image)) {
                Storage::disk('public')->delete($this->seo->og_image);
            }

            $data['og_image'] = $request->file('og_image')->store('seo/og-images', 'public');
        }

        $this->seo()->updateOrCreate(
            [
                'seoable_type' => get_class($this),
                'seoable_id' => $this->id,
            ],
            $data
        );
    }
}
