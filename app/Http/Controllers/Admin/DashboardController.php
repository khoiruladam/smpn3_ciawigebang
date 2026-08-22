<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use App\Models\Guru;
use App\Models\Achievement;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_berita' => Schema::hasTable('posts') ? Post::count() : 0,
            'total_guru' => Schema::hasTable('gurus') ? Guru::count() : 0,
            'total_prestasi' => Schema::hasTable('achievements') ? Achievement::count() : 0,
            'total_pesan' => Schema::hasTable('contact_messages') ? ContactMessage::count() : 0,
        ];

        // Mengambil data terbaru untuk ditampilkan di tabel
        $latestPosts = Schema::hasTable('posts') ? Post::latest()->take(5)->get() : collect();
        $latestMessages = Schema::hasTable('contact_messages') ? ContactMessage::latest()->take(5)->get() : collect();

        return view('admin.dashboard', compact('stats', 'latestPosts', 'latestMessages'));
    }
}