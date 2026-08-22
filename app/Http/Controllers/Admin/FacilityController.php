<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('sort_order')->paginate(10);

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['nullable', 'string', 'max:100'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'cover_image' => ['required', 'image', 'max:2048'], // max 2MB
            'sort_order' => ['nullable', 'integer'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['cover_image'] = $request->file('cover_image')->store('facilities', 'public');
        $validated['is_published'] = $request->boolean('is_published', true);

        $facility = Facility::create($validated);

        // Simpan galeri foto tambahan, kalau ada
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                FacilityImage::create([
                    'facility_id' => $facility->id,
                    'image_path' => $file->store('facilities', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        $facility->load('images');

        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'icon' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['nullable', 'string', 'max:100'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'], // opsional saat update
            'sort_order' => ['nullable', 'integer'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_published'] = $request->boolean('is_published', true);

        // Ganti cover cuma kalau upload file baru
        if ($request->hasFile('cover_image')) {
            if ($facility->cover_image) {
                Storage::disk('public')->delete($facility->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('facilities', 'public');
        }

        $facility->update($validated);

        // Tambah foto galeri baru (kalau ada), foto lama tetap dipertahankan
        if ($request->hasFile('gallery')) {
            $startOrder = $facility->images()->max('sort_order') + 1;
            foreach ($request->file('gallery') as $index => $file) {
                FacilityImage::create([
                    'facility_id' => $facility->id,
                    'image_path' => $file->store('facilities', 'public'),
                    'sort_order' => $startOrder + $index,
                ]);
            }
        }

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        // Hapus semua file fisik: cover + galeri
        if ($facility->cover_image) {
            Storage::disk('public')->delete($facility->cover_image);
        }
        foreach ($facility->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $facility->delete(); // facility_images ikut kehapus otomatis (cascadeOnDelete di migration)

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }

    // Hapus satu foto galeri tanpa hapus seluruh fasilitas
    public function destroyImage(FacilityImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}