<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeoRequest;
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
        $orderPreview = Facility::orderBy('sort_order')->select(['id', 'name', 'sort_order'])->get();

        return view('admin.facilities.index', compact('facilities', 'orderPreview'));
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
            'cover_image' => ['required', 'image', 'max:1024'], // max 1MB
            'sort_order' => ['nullable', 'integer'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:1024'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['cover_image'] = $request->file('cover_image')->store('facilities', 'public');
        $validated['is_published'] = $request->boolean('is_published', true);

        $request->validate(SeoRequest::seoRules());

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

        $facility->saveSeo($request);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        $facility->load('images', 'seo');

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
            'cover_image' => ['nullable', 'image', 'max:1024'], // opsional saat update
            'sort_order' => ['nullable', 'integer'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:1024'],
        ]);

        if ($request->filled('slug')) {
            $validated['slug'] = Str::slug($request->slug);
        } elseif (empty($facility->slug)) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            unset($validated['slug']);
        }
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

        $request->validate(SeoRequest::seoRules());
        $facility->saveSeo($request);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        // Kumpulkan path file yang akan dihapus
        $cover = $facility->cover_image;
        $galleryPaths = $facility->images->pluck('image_path')->toArray();

        // Hapus dari database terlebih dahulu (facility_images ikut kehapus otomatis via cascadeOnDelete)
        if ($facility->delete()) {
            // Jika DB berhasil dihapus, hapus file fisiknya
            if ($cover) {
                Storage::disk('public')->delete($cover);
            }
            foreach ($galleryPaths as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }

    // Hapus satu foto galeri tanpa hapus seluruh fasilitas
    public function destroyImage(FacilityImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * Simpan urutan baru dari drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            foreach ($request->order as $index => $id) {
                Facility::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        return response()->json(['success' => true]);
    }
}