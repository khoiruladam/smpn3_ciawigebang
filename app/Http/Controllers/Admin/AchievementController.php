<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeoRequest;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderBy('sort_order')->paginate(10);
        $orderPreview = Achievement::orderBy('sort_order')->select(['id', 'title', 'sort_order'])->get();
        return view('admin.prestasi.index', compact('achievements', 'orderPreview'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'year' => 'required|string|max:4',
            'icon' => 'required|string|max:50',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'cover_image' => 'required|image|max:1024',
            'gallery.*' => 'nullable|image|max:1024',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('achievements', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('achievements/gallery', 'public');
            }
        }
        $validated['gallery'] = $galleryPaths;
        $validated['slug'] = Str::slug($request->title);
        $validated['is_published'] = $request->has('is_published');

        $request->validate(SeoRequest::seoRules());

        $achievement = Achievement::create($validated);
        $achievement->saveSeo($request);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $prestasi)
    {
        $prestasi->load('seo');
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Achievement $prestasi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'year' => 'required|string|max:4',
            'icon' => 'required|string|max:50',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:1024',
            'gallery.*' => 'nullable|image|max:1024',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($prestasi->cover_image)
                Storage::disk('public')->delete($prestasi->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('achievements', 'public');
        }

        if ($request->hasFile('gallery')) {
            $currentGallery = is_array($prestasi->gallery) ? $prestasi->gallery : [];
            foreach ($request->file('gallery') as $file) {
                $currentGallery[] = $file->store('achievements/gallery', 'public');
            }
            $validated['gallery'] = $currentGallery;
        }

        if ($request->filled('slug')) {
            $validated['slug'] = Str::slug($request->slug);
        } elseif (empty($prestasi->slug)) {
            $validated['slug'] = Str::slug($request->title);
        } else {
            unset($validated['slug']);
        }
        $validated['is_published'] = $request->has('is_published');

        $request->validate(SeoRequest::seoRules());

        $prestasi->update($validated);
        $prestasi->saveSeo($request);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $prestasi)
    {
        if ($prestasi->cover_image)
            Storage::disk('public')->delete($prestasi->cover_image);
        if (is_array($prestasi->gallery)) {
            foreach ($prestasi->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }

    public function destroyGallery(Achievement $prestasi, $index)
    {
        $gallery = is_array($prestasi->gallery) ? $prestasi->gallery : [];
        if (isset($gallery[$index])) {
            Storage::disk('public')->delete($gallery[$index]);
            unset($gallery[$index]);
            $prestasi->update(['gallery' => array_values($gallery)]);
        }
        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    /**
     * Simpan urutan baru dari drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            foreach ($request->order as $index => $id) {
                Achievement::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        return response()->json(['success' => true]);
    }
}