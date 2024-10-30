<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Collection::macro('paginate', function ($perPage = 10, $page = null, $options = []) {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage();
            $items = $this->forPage($page, $perPage);
    
            return new LengthAwarePaginator(
                $items,
                $this->count(),
                $perPage,
                $page,
                $options + ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        });
    }
}
