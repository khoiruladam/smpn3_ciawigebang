<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
     /**
      * Mengambil nilai pengaturan berdasarkan key.
      *
      * Semua settings di-cache sebagai satu key 'app_settings' selama 1 hari.
      * Cache otomatis di-clear saat admin mengupdate pengaturan di SettingController.
      */
     function setting($key, $default = null)
     {
          try {
               $settings = Cache::remember('app_settings', now()->addDay(), function () {
                    return Setting::pluck('value', 'key')->toArray();
               });

               return array_key_exists($key, $settings) ? $settings[$key] : $default;
          } catch (\Exception $e) {
               return $default;
          }
     }
}