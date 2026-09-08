<?php

namespace App\Http\Controllers;

use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        $prestasiList = Achievement::where('is_published', true)
            ->latest()
            ->paginate(9);

        return view('templates.prestasi-index', compact('prestasiList'));
    }

    public function show(Achievement $prestasi)
    {
        if (!$prestasi->is_published) {
            abort(404);
        }

        $prestasi->load('seo');

        return view('templates.show', [
            'item' => $prestasi,
            'type' => 'Prestasi & Penghargaan',
            'backUrl' => url('/#prestasi'),
            'backLabel' => 'Kembali ke Daftar Prestasi'
        ]);
    }
}