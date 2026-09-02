<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillGallerySlugs extends Command
{
    protected $signature = 'gallery:backfill-slugs';
    protected $description = 'Mengisi slug untuk data galeri yang belum memiliki slug.';

    public function handle(): int
    {
        $galleries = Gallery::whereNull('slug')->orWhere('slug', '')->get();

        if ($galleries->isEmpty()) {
            $this->info('Semua data galeri sudah memiliki slug. Tidak ada yang perlu di-update.');
            return self::SUCCESS;
        }

        $this->info("Ditemukan {$galleries->count()} galeri tanpa slug. Memproses...");

        $bar = $this->output->createProgressBar($galleries->count());
        $bar->start();

        foreach ($galleries as $gallery) {
            $baseSlug = Str::slug($gallery->title);
            $slug = $baseSlug;
            $counter = 1;

            // Handle slug duplikat
            while (Gallery::where('slug', $slug)->where('id', '!=', $gallery->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $gallery->update(['slug' => $slug]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Selesai! {$galleries->count()} galeri berhasil diisi slug-nya.");

        return self::SUCCESS;
    }
}
