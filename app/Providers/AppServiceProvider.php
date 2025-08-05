<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\ClientInterface;
use App\Repositories\Interfaces\SubscriptionItemInterface;
use App\Repositories\Interfaces\StockMovementInterface;
use App\Repositories\Interfaces\TransactionInterface;
use App\Repositories\Interfaces\CategoryTransactionInterface;
use App\Repositories\Interfaces\UserInterface;


use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\SubscriptionItemRepository;
use App\Repositories\Eloquent\StockMovementRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\CategoryTransactionRepository;
use App\Repositories\Eloquent\UserRepository;

use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ClientInterface::class, ClientRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(StockMovementInterface::class, StockMovementRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(CategoryTransactionInterface::class, CategoryTransactionRepository::class);
        $this->app->bind(SubscriptionItemInterface::class, SubscriptionItemRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
