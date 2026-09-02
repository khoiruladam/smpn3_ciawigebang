<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Achievement;
use App\Models\Ekskul;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Guru;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    /**
     * Mapping eksplisit per model — menggantikan logic tebak-tebakan otomatis
     * (Schema::hasColumn) yang sebelumnya rawan silent failure.
     *
     * Setiap entry mendefinisikan:
     * - titleColumn  : kolom yang di-search (LIKE) dan ditampilkan sebagai judul
     * - imageColumn  : kolom gambar untuk thumbnail (nullable)
     * - typeLabel     : label kategori untuk UI
     * - route         : named route untuk URL klik hasil pencarian
     * - routeParam    : field model yang dijadikan parameter route (biasanya 'slug')
     * - hasSlug       : apakah model punya kolom slug (untuk filter whereNotNull)
     * - selectColumns : kolom-kolom minimal yang di-select (hindari select *)
     */
    private const MODEL_CONFIG = [
        Post::class => [
            'titleColumn'  => 'title',
            'imageColumn'  => 'image',
            'typeLabel'    => 'Berita',
            'route'        => 'berita.show',
            'routeParam'   => 'slug',
            'hasSlug'      => true,
            'selectColumns' => ['title', 'slug', 'image', 'created_at'],
        ],
        Facility::class => [
            'titleColumn'  => 'name',
            'imageColumn'  => 'cover_image',
            'typeLabel'    => 'Fasilitas',
            'route'        => 'facilities.show',
            'routeParam'   => 'slug',
            'hasSlug'      => true,
            'selectColumns' => ['name', 'slug', 'cover_image', 'created_at'],
        ],
        Ekskul::class => [
            'titleColumn'  => 'name',
            'imageColumn'  => 'cover_image',
            'typeLabel'    => 'Ekstrakurikuler',
            'route'        => 'ekskul.show',
            'routeParam'   => 'slug',
            'hasSlug'      => true,
            'selectColumns' => ['name', 'slug', 'cover_image', 'created_at'],
        ],
        Achievement::class => [
            'titleColumn'  => 'title',
            'imageColumn'  => 'cover_image',
            'typeLabel'    => 'Prestasi',
            'route'        => 'prestasi.show',
            'routeParam'   => 'slug',
            'hasSlug'      => true,
            'selectColumns' => ['title', 'slug', 'cover_image', 'created_at'],
        ],
        Guru::class => [
            'titleColumn'  => 'name',
            'imageColumn'  => 'image',
            'typeLabel'    => 'Guru & Staff',
            'route'        => 'guru.index',
            'routeParam'   => null,   // tidak pakai parameter (langsung ke /guru-staff)
            'hasSlug'      => false,
            'selectColumns' => ['name', 'image', 'jabatan', 'created_at'],
        ],
        Gallery::class => [
            'titleColumn'  => 'title',
            'imageColumn'  => 'image',
            'typeLabel'    => 'Galeri',
            'route'        => 'gallery.index',
            'routeParam'   => null,   // tidak ada gallery.show, langsung ke /galeri
            'hasSlug'      => false,  // slug ada tapi nullable, dan tidak dipakai di route
            'selectColumns' => ['title', 'image', 'created_at'],
        ],
    ];

    /**
     * Quick Search endpoint — mengembalikan JSON hasil pencarian.
     * Menerima parameter 'q' yang sudah divalidasi oleh SearchRequest.
     */
    public function quick(SearchRequest $request)
    {
        $q = trim($request->validated('q', '') ?? '');

        // Kalau query kosong: hanya tampilkan Berita Terbaru
        if ($q === '') {
            $config = self::MODEL_CONFIG[Post::class];

            $posts = Post::where('is_published', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->select($config['selectColumns'])
                ->latest()
                ->take(6)
                ->get();

            return response()->json($this->formatResults($posts, Post::class));
        }

        $results = collect();

        // Daftar model yang dicari beserta batas hasil per model
        $searchModels = [
            Post::class        => 4,
            Facility::class    => 3,
            Ekskul::class      => 3,
            Achievement::class => 3,
            Guru::class        => 3,
            Gallery::class     => 3,
        ];

        foreach ($searchModels as $modelClass => $limit) {
            $config = self::MODEL_CONFIG[$modelClass];

            $query = $modelClass::where('is_published', true)
                ->where($config['titleColumn'], 'like', "%{$q}%")
                ->select($config['selectColumns']);

            // Proteksi: hanya ambil record yang punya slug valid (untuk model yang pakai slug)
            if ($config['hasSlug']) {
                $query->whereNotNull('slug')->where('slug', '!=', '');
            }

            $items = $query->latest()->take($limit)->get();

            $results = $results->merge($this->formatResults($items, $modelClass));
        }

        return response()->json($results->take(12)->values());
    }

    /**
     * Format hasil query jadi array seragam untuk response JSON.
     * Hanya mengirim field yang dibutuhkan frontend (title, type, url, image, date)
     * — tidak ada ID internal atau path storage mentah yang bocor.
     */
    private function formatResults($items, string $modelClass): array
    {
        $config = self::MODEL_CONFIG[$modelClass];

        return $items->map(function ($item) use ($config) {
            $title = $item->{$config['titleColumn']} ?? '(tanpa judul)';

            // Generate URL berdasarkan config route
            if ($config['routeParam'] !== null) {
                $url = route($config['route'], $item->{$config['routeParam']});
            } else {
                $url = route($config['route']);
            }

            // Ambil gambar dari kolom yang benar sesuai mapping
            $imageField = $config['imageColumn'];
            $image = $imageField ? ($item->{$imageField} ?? null) : null;

            return [
                'title' => $title,
                'type'  => $config['typeLabel'],
                'url'   => $url,
                'image' => $image ? Storage::url($image) : null,
                'date'  => $item->created_at?->translatedFormat('d M Y'),
            ];
        })->toArray();
    }
}