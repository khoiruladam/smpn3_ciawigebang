<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContactMessage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengirim data jumlah pesan belum dibaca secara global ke layout admin
        View::composer('layouts.admin', function ($view) {
            $unreadCount = ContactMessage::where('is_read', false)->count();

            $view->with('unreadMessagesCount', $unreadCount);
        });
    }
}