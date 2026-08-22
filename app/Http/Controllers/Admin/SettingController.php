<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan sekolah.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Menyimpan atau memperbarui data pengaturan (teks, file gambar, dan data JSON dinamis).
     */
    public function update(Request $request)
    {
        // Hapus cache settings agar perubahan langsung terlihat di halaman publik
        Cache::forget('app_settings');

        // Daftar semua input yang berupa FILE (Gambar)
        $fileInputs = ['logo', 'bg_login', 'login_card_image', 'bg_hero', 'bg_guru', 'bg_ssk', 'bg_ekskul'];

        // 1. MENYIMPAN DATA FITUR (JSON)
        $features = [];
        if ($request->has('features')) {
            foreach ($request->features as $feat) {
                if (!empty($feat['title']) || !empty($feat['icon'])) {
                    $features[] = [
                        'icon' => $feat['icon'] ?? 'ti-star',
                        'title' => $feat['title'] ?? '',
                        'desc' => $feat['desc'] ?? ''
                    ];
                }
            }
        }
        Setting::updateOrCreate(['key' => 'features_data'], ['value' => json_encode($features)]);

        // 2. MENYIMPAN DATA SOSIAL MEDIA (JSON)
        $socials = [];
        if ($request->has('socials')) {
            foreach ($request->socials as $soc) {
                if (!empty($soc['name']) || !empty($soc['url'])) {
                    $socials[] = [
                        'name' => $soc['name'] ?? '',
                        'icon' => $soc['icon'] ?? 'ti-world',
                        'url' => $soc['url'] ?? '#'
                    ];
                }
            }
        }
        Setting::updateOrCreate(['key' => 'socials_data'], ['value' => json_encode($socials)]);

        // 3. MENYIMPAN DATA PROFIL DINAMIS (VISI, MISI, AKREDITASI, DLL SEBAGAI JSON)
        $profilPoints = [];
        if ($request->has('profil')) {
            foreach ($request->profil as $p) {
                if (!empty($p['label']) || !empty($p['text'])) {
                    $profilPoints[] = [
                        'icon' => $p['icon'] ?? 'ti-target-arrow',
                        'label' => $p['label'] ?? '',
                        'text' => $p['text'] ?? '',
                        'icon_bg' => $p['icon_bg'] ?? 'bg-blue-50 text-blue-600 border-blue-100',
                        'badge' => $p['badge'] ?? '',
                        'keterangan' => $p['keterangan'] ?? ''
                    ];
                }
            }
        }
        Setting::updateOrCreate(['key' => 'profil_points_data'], ['value' => json_encode($profilPoints)]);

        // 4. MENYIMPAN DATA TEKS BIASA 
        // (PERBAIKAN: Masukkan 'profil', 'features', dan 'socials' ke dalam excludedKeys)
        $excludedKeys = array_merge(['_token', '_method', 'features', 'socials', 'profil'], $fileInputs);
        $textData = $request->except($excludedKeys);

        foreach ($textData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // 5. MENANGANI UPLOAD SEMUA GAMBAR SECARA OTOMATIS
        foreach ($fileInputs as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $oldSetting = Setting::where('key', $fileKey)->first();

                if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                $path = $request->file($fileKey)->store('settings', 'public');

                Setting::updateOrCreate(
                    ['key' => $fileKey],
                    ['value' => $path]
                );
            }
        }

        return redirect()->back()->with('success', 'Pengaturan sekolah berhasil diperbarui!');
    }
}