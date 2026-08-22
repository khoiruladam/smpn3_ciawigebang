<?php

namespace App\Http\Controllers;

use App\Models\Achievement;

class AchievementController extends Controller
{
    public function show(Achievement $prestasi)
    {
        if (!$prestasi->is_published) {
            abort(404);
        }

        return view('templates.show', [
            'item' => $prestasi,
            'type' => 'Prestasi & Penghargaan',
            'backUrl' => url('/#prestasi'),
            'backLabel' => 'Kembali ke Daftar Prestasi'
        ]);
    }
}