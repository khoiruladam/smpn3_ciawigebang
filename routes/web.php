<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SskController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\EkskulController as AdminEkskulController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SettingController; // <-- Controller Setting
use App\Http\Controllers\ContactController;
use App\Models\SskStat;
use App\Models\SskDemographic;
use App\Models\Facility;
use App\Models\Ekskul;
use App\Models\Achievement;
use App\Models\Guru;
use App\Models\Gallery;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $chartData = Achievement::where('is_published', true)
        ->select('year', \DB::raw('count(*) as total'))
        ->groupBy('year')
        ->orderBy('year', 'asc')
        ->get();

    return view('welcome', [
        'akreditasi' => 'A',
        'sskItems' => SskStat::orderBy('sort_order')->get(),
        'demographics' => SskDemographic::orderBy('sort_order')->get(),
        'fasilitas' => Facility::where('is_published', true)->orderBy('sort_order')->get(),
        'ekskulItems' => Ekskul::where('is_published', true)->orderBy('sort_order')->get(),
        'prestasiItems' => Achievement::where('is_published', true)->orderBy('sort_order')->get(),
        'totalPrestasiCount' => Achievement::where('is_published', true)->count(),
        'chartYears' => $chartData->pluck('year')->toArray(),
        'chartCounts' => $chartData->pluck('total')->toArray(),
        'kepsek' => Guru::where('category', 'kepsek')->where('is_published', true)->first(),
        'wakel' => Guru::where('category', 'wakel')->where('is_published', true)->first(),
        'guruList' => Guru::where('category', 'guru')->where('is_published', true)->orderBy('sort_order')->get(),
        'fotos' => Gallery::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
        'beritaUtama' => Post::where('is_published', true)->latest()->take(3)->get(),
    ]);
})->name('home');

/*
|--------------------------------------------------------------------------
| Rute Publik Menggunakan Template Show Tunggal
|--------------------------------------------------------------------------
*/
Route::get('/fasilitas/{facility:slug}', function (Facility $facility) {
    if (!$facility->is_published) {
        abort(404);
    }
    $facility->load('seo');
    return view('templates.show', [
        'item' => $facility,
        'type' => 'Fasilitas Sekolah',
        'backUrl' => url('/#fasilitas'),
        'backLabel' => 'Kembali ke Fasilitas'
    ]);
})->name('facilities.show');

Route::get('/ekskul/{ekskul:slug}', function (Ekskul $ekskul) {
    if (!$ekskul->is_published) {
        abort(404);
    }
    $ekskul->load('seo');
    return view('templates.show', [
        'item' => $ekskul,
        'type' => 'Ekstrakurikuler',
        'backUrl' => url('/#ekskul'),
        'backLabel' => 'Kembali ke Ekstrakurikuler'
    ]);
})->name('ekskul.show');

Route::get('/prestasi/{prestasi:slug}', function (Achievement $prestasi) {
    if (!$prestasi->is_published) {
        abort(404);
    }
    $prestasi->load('seo');
    return view('templates.show', [
        'item' => $prestasi,
        'type' => 'Prestasi & Penghargaan',
        'backUrl' => url('/#prestasi'),
        'backLabel' => 'Kembali ke Prestasi'
    ]);
})->name('prestasi.show');

Route::get('/guru-staff', function () {
    return view('templates.guru-index', [
        'gurus' => Guru::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
    ]);
})->name('guru.index');

Route::get('/galeri', function () {
    return view('templates.gallery-index', [
        'fotos' => Gallery::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
    ]);
})->name('gallery.index');

Route::get('/berita/{post:slug}', function (Post $post) {
    if (!$post->is_published) {
        abort(404);
    }
    $post->load('seo');
    return view('templates.post-show', [
        'post' => $post,
        'recentPosts' => Post::where('is_published', true)->where('id', '!=', $post->id)->latest()->take(3)->get()
    ]);
})->name('berita.show');

Route::get('/berita', function () {
    return view('templates.post-index', [
        'posts' => Post::where('is_published', true)->latest()->paginate(6)
    ]);
})->name('berita.index');

Route::post('/kontak', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware(['throttle:3,1', 'throttle:10,1440']);

Route::get('/pencarian-cepat', [App\Http\Controllers\SearchController::class, 'quick'])
    ->name('search.quick')
    ->middleware('throttle:30,1');

/*
|--------------------------------------------------------------------------
| Sitemap XML Dinamis
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', function () {
    $posts = Post::where('is_published', true)->select('slug', 'updated_at')->latest()->get();
    $ekskuls = Ekskul::where('is_published', true)->select('slug', 'updated_at')->orderBy('sort_order')->get();
    $facilities = Facility::where('is_published', true)->select('slug', 'updated_at')->orderBy('sort_order')->get();
    $achievements = Achievement::where('is_published', true)->select('slug', 'updated_at')->orderBy('sort_order')->get();

    $content = view('partials._sitemap', compact('posts', 'ekskuls', 'facilities', 'achievements'))->render();

    return response($content, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/fitur-baru', function () {
    return view('maintenance');
});
/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.store')
        ->middleware('throttle:10,1'); // maksimal 10 request/menit ke endpoint ini
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Area Admin & Operator — konten umum
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,operator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Fasilitas
        Route::resource('facilities', FacilityController::class)->except(['show']);
        Route::delete('/facility-images/{image}', [FacilityController::class, 'destroyImage'])
            ->name('facilities.images.destroy');

        // Manajemen Ekstrakurikuler
        Route::resource('ekskul', AdminEkskulController::class)->except(['show']);
        Route::delete('/ekskul/{ekskul}/gallery/{index}', [AdminEkskulController::class, 'destroyGallery'])
            ->name('ekskul.gallery.destroy');

        // Manajemen Prestasi
        Route::resource('prestasi', AdminAchievementController::class)->except(['show']);
        Route::delete('/prestasi/{prestasi}/gallery/{index}', [AdminAchievementController::class, 'destroyGallery'])
            ->name('prestasi.gallery.destroy');

        // Manajemen Guru & Staff
        Route::resource('guru', AdminGuruController::class)->except(['show']);

        // Manajemen Galeri
        Route::resource('gallery', AdminGalleryController::class)->except(['show']);

        // Manajemen Berita & Artikel
        Route::resource('posts', AdminPostController::class)->except(['show']);

        // Pesan Masuk — bisa diakses Admin & Operator
        Route::resource('messages', ContactMessageController::class)
            ->only(['index', 'show', 'destroy']);

        // Data SSK — bisa diakses Admin & Operator
        Route::get('/ssk', [SskController::class, 'index'])->name('ssk.index');

        Route::prefix('ssk/stats')->name('ssk.stats.')->group(function () {
            Route::get('/create', [SskController::class, 'createStat'])->name('create');
            Route::post('/', [SskController::class, 'storeStat'])->name('store');
            Route::get('/{stat}/edit', [SskController::class, 'editStat'])->name('edit');
            Route::put('/{stat}', [SskController::class, 'updateStat'])->name('update');
            Route::delete('/{stat}', [SskController::class, 'destroyStat'])->name('destroy');
        });

        Route::prefix('ssk/demographics')->name('ssk.demographics.')->group(function () {
            Route::get('/create', [SskController::class, 'createDemographic'])->name('create');
            Route::post('/', [SskController::class, 'storeDemographic'])->name('store');
            Route::get('/{demographic}/edit', [SskController::class, 'editDemographic'])->name('edit');
            Route::put('/{demographic}', [SskController::class, 'updateDemographic'])->name('update');
            Route::delete('/{demographic}', [SskController::class, 'destroyDemographic'])->name('destroy');
        });

        // Reorder endpoint untuk drag-and-drop sort order
        Route::post('facilities/reorder', [FacilityController::class, 'reorder'])->name('facilities.reorder');
        Route::post('ekskul/reorder', [AdminEkskulController::class, 'reorder'])->name('ekskul.reorder');
        Route::post('prestasi/reorder', [AdminAchievementController::class, 'reorder'])->name('prestasi.reorder');
        Route::post('guru/reorder', [AdminGuruController::class, 'reorder'])->name('guru.reorder');
        Route::post('gallery/reorder', [AdminGalleryController::class, 'reorder'])->name('gallery.reorder');
    });

/*
|--------------------------------------------------------------------------
| Area Admin SAJA — data sensitif (Kelola Pengguna & Pengaturan Sistem)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserManagementController::class)->except(['show']);

        // Manajemen Pengaturan Sekolah (Settings) — khusus Admin
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });