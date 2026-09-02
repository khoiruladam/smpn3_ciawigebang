<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request khusus validasi field SEO.
 * Semua field nullable — tidak boleh mengganggu validasi form utama.
 */
class SeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi field SEO — dipanggil terpisah via validate() di controller,
     * bukan sebagai type-hint parameter (agar tidak mengganggu validasi form utama).
     */
    public static function seoRules(): array
    {
        return [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'canonical_url' => 'nullable|url|max:255',
        ];
    }
}
