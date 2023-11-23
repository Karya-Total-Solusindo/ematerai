<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mockery\Matcher\Any;
use Illuminate\Pagination\Paginator;

class AlertServiceProvider extends ServiceProvider
{
 
    /**
     * Bootstrap your package's services.
     */
    public function boot(): void
    {
        Blade::component('alert', Alert::class);
    }
}