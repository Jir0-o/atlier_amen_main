<?php

namespace App\Providers;

use App\Models\Work;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Models\TempCart;

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
        View::composer('frontend.partials._navbar', function ($view) {
            $view->with('navCategories', Category::where('is_active', 1)->where('is_vip', 0)->orderBy('name')->get());
            $view->with('searchProducts', Work::where('is_active', 1)->orderBy('name')->get());
        });
        // Merge temp cart with logged-in user
        Event::listen(Login::class, function ($event) {
            $sessionId = session()->getId();
            TempCart::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->update(['user_id' => $event->user->id]);
        });
    }
}
