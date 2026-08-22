<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    public function show(Ekskul $ekskul)
    {
        // Pastikan hanya ekskul yang di-publish yang bisa diakses publik
        if (!$ekskul->is_published) {
            abort(404);
        }

        // Tampilkan ke view publik (menggunakan view yang sudah dipoles sebelumnya)
        return view('ekskul.show', compact('ekskul'));
    }
}