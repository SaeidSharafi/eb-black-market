<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;

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
        Model::preventLazyLoading();
        //\Event::listen(QueryExecuted::class, function (QueryExecuted $query) {
        //    if ($this->app->environment('local')) {
        //        \Log::debug("Query Executed: ", [
        //            "sql" => $query->sql,
        //            "bindings" => $query->bindings,
        //            "connection" => $query->connectionName,
        //        ]);
        //    }
        //});
    }
}
