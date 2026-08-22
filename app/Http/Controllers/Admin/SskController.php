<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SskDemographic;
use App\Models\SskStat;
use Illuminate\Http\Request;

class SskController extends Controller
{
    public function index()
    {
        $stats = SskStat::orderBy('sort_order')->get();
        $demographics = SskDemographic::orderBy('sort_order')->get();

        return view('admin.ssk.index', compact('stats', 'demographics'));
    }

    // ===== Stat Cards =====

    public function createStat()
    {
        return view('admin.ssk.create-stat');
    }

    public function storeStat(Request $request)
    {
        $validated = $request->validate([
            'icon' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'decimals' => ['required', 'integer', 'min:0', 'max:2'],
            'sub' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        SskStat::create($validated);

        return redirect()->route('admin.ssk.index')->with('success', 'Kartu statistik berhasil ditambahkan.');
    }

    public function editStat(SskStat $stat)
    {
        return view('admin.ssk.edit-stat', compact('stat'));
    }

    public function updateStat(Request $request, SskStat $stat)
    {
        $validated = $request->validate([
            'icon' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'decimals' => ['required', 'integer', 'min:0', 'max:2'],
            'sub' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $stat->update($validated);

        return redirect()->route('admin.ssk.index')->with('success', 'Kartu statistik berhasil diperbarui.');
    }

    public function destroyStat(SskStat $stat)
    {
        $stat->delete();

        return back()->with('success', 'Kartu statistik berhasil dihapus.');
    }

    // ===== Data Demografi (grafik) =====

    public function createDemographic()
    {
        return view('admin.ssk.create-demographic');
    }

    public function storeDemographic(Request $request)
    {
        $validated = $request->validate([
            'kelas' => ['required', 'string', 'max:100'],
            'male_count' => ['required', 'integer', 'min:0'],
            'female_count' => ['required', 'integer', 'min:0'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        SskDemographic::create($validated);

        return redirect()->route('admin.ssk.index')->with('success', 'Data demografi berhasil ditambahkan.');
    }

    public function editDemographic(SskDemographic $demographic)
    {
        return view('admin.ssk.edit-demographic', compact('demographic'));
    }

    public function updateDemographic(Request $request, SskDemographic $demographic)
    {
        $validated = $request->validate([
            'kelas' => ['required', 'string', 'max:100'],
            'male_count' => ['required', 'integer', 'min:0'],
            'female_count' => ['required', 'integer', 'min:0'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $demographic->update($validated);

        return redirect()->route('admin.ssk.index')->with('success', 'Data demografi berhasil diperbarui.');
    }

    public function destroyDemographic(SskDemographic $demographic)
    {
        $demographic->delete();

        return back()->with('success', 'Data demografi berhasil dihapus.');
    }
}